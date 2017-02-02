<?php

namespace svil4ok\Validation;

use svil4ok\Validation\Contracts\Rule;
use svil4ok\Validation\Helpers\Arr;
use svil4ok\Validation\Rules\Boolean;
use svil4ok\Validation\Rules\Date;
use svil4ok\Validation\Rules\DateAfter;
use svil4ok\Validation\Rules\DateBefore;
use svil4ok\Validation\Rules\Max;
use svil4ok\Validation\Rules\Min;
use svil4ok\Validation\Rules\Required;

class Validator
{
    /**
     * The data under validation.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The message bag instance.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * The array of custom error messages.
     *
     * @var array
     */
    protected $customMessages = [];

    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $messageSeparator = '.';

    /**
     * Validator constructor.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     */
    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->messages = new MessageBag;
        $this->customMessages = $messages;

        $this->registerDefaultValidators();

        $this->data = $this->parseData($data);

        $this->setRules($rules);
    }

    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     *
     * @return $this
     */
    public static function make(array $data, array $rules, array $messages = [])
    {
        return (new self($data, $rules, $messages))->run();
    }

    /**
     * Run validaiton.
     *
     * @return $this
     */
    public function run()
    {
        foreach($this->attributes as $attributeKey => $attribute) {
            $this->validateAttribute($attribute);
        }

        return $this;
    }

    /**
     * Validate each attribute applied rules.
     *
     * @param Attribute $attribute
     *
     * @return void
     */
    protected function validateAttribute(Attribute $attribute)
    {
        if ($this->hasAsterisks($attribute)) {
            $asteriskAttributes = $this->parseAsteriskAttribute($attribute);

            foreach ($asteriskAttributes as $asteriskAttribute) {
                $this->validateAttribute($asteriskAttribute);
            }
        }

        $attributeKey = $attribute->getKey();
        $rules = $attribute->getRules();
        $value = $this->getValue($attributeKey);
        $isEmptyValue = $this->isEmpty($value);
        $isOptional = $this->isOptional($attribute);

        if ($isEmptyValue && $isOptional) {
            return;
        }

        foreach ($rules as $rule) {
            $isValid = $rule->passes($value);

            if ($isValid !== true) {
                $this->addError($attribute, $value, $rule);
            }
        }
    }

    /**
     * Determine if the attribute key has an asterisk (*) symbol.
     *
     * @param Attribute $attribute
     *
     * @return bool
     */
    protected function hasAsterisks(Attribute $attribute) : bool
    {
        return strpos($attribute->getKey(), '*') !== false;
    }

    /**
     * Parse attribute array values by applying attribute's rules for each value.
     *
     * @param Attribute $attribute
     *
     * @return array
     */
    protected function parseAsteriskAttribute(Attribute $attribute) : array
    {
        $asteriskKey = $attribute->getKey();

        $data = $this->getAsteriskAttributeData($asteriskKey);
        $data = Arr::dot($data);

        $data = array_merge($data, $this->extractWildcardsValues($data, $asteriskKey));

        $pattern = str_replace('\*', '[^\.]+', preg_quote($asteriskKey));

        $attributes = [];

        foreach ($data as $key => $value) {
            if ((bool) preg_match('/^' . $pattern . '\z/', $key)) {
                $attributes[] =  new Attribute($key, $attribute->getRules(), $attribute->isRequired());
            }
        }

        return $attributes;
    }

    /**
     * Gather a copy of the attribute data filled with any missing attributes.
     *
     * @param string $attributeKey
     *
     * @return array
     */
    protected function getAsteriskAttributeData($attributeKey)
    {
        $leadingKey = $this->getLeadingKey($attributeKey);

        $data = $this->extractDataFromPath($leadingKey);

        $asteriksPosition = strpos($attributeKey, '*');

        if ($asteriksPosition === false || ($asteriksPosition === strlen($attributeKey) - 1)) {
            return $data;
        }

        return Arr::set($data, $attributeKey, null, true);
    }

    /**
     * Get the explicit part of the attribute name.
     *
     * e.g. 'foo.bar.*.baz' --> 'foo.bar'
     *
     * @param string $attributeKey
     *
     * @return string|null
     */
    protected function getLeadingKey($attributeKey)
    {
        return rtrim(explode('*', $attributeKey)[0], '.') ?: null;
    }

    /**
     * Extract data based on the given dot-notated path.
     *
     * @param string $attributeKey
     *
     * @return array
     */
    protected function extractDataFromPath(string $attributeKey) : array
    {
        $data = [];

        $defaultValue = '__empty__';
        $extractedData = Arr::get($this->data, $attributeKey, $defaultValue);

        if ($extractedData !== $defaultValue) {
            $data = Arr::set($data, $attributeKey, $extractedData);
        }

        return $data;
    }

    /**
     * Extract attribute values for a given wildcard attribute.
     *
     * @param array $data
     * @param string $attributeKey
     *
     * @return array
     */
    protected function extractWildcardsValues(array $data, string $attributeKey) : array
    {
        $keys = [];

        $pattern = str_replace('\*', '[^\.]+', preg_quote($attributeKey));

        foreach ($data as $key => $value) {
            if ((bool) preg_match('/^' . $pattern . '/', $key, $matches)) {
                $keys[] = $matches[0];
            }
        }

        $keys = array_unique($keys);

        $data = [];

        foreach ($keys as $key) {
            $data[$key] = Arr::get($this->data, $key);
        }

        return $data;
    }

    /**
     * @param Attribute $attribute
     * @param $value
     * @param Rule $rule
     *
     * @return void
     */
    protected function addError(Attribute $attribute, $value, Rule $rule)
    {
        $message = $this->resolveMessage($attribute, $value, $rule);

        $this->messages->add($attribute->getKey(), $message);
    }

    /**
     * Retrieve rule error message.
     *
     * @param Attribute $attribute
     * @param $value
     * @param Rule $rule
     *
     * @return mixed|string
     */
    protected function resolveMessage(Attribute $attribute, $value, Rule $rule)
    {
        $params = $rule->getParams();
        $attributeKey = $attribute->getKey();
        $slug = $rule->getSlug();

        $message = $this->customMessages[$attributeKey . $this->messageSeparator . $slug] ?? $rule->getMessage();

        $vars = array_merge($params, [
            'attribute' => $attributeKey,
            'value' => $value,
        ]);

        foreach ($vars as $key => $value) {
            $value = $this->stringify($value);

            $message = str_replace(':' . $key, $value, $message);
        }

        return $message;
    }

    /**
     * Get the value of a given attribute.
     *
     * @param string $attributeKey
     *
     * @return mixed|null
     */
    protected function getValue($attributeKey)
    {
        return Arr::get($this->data, $attributeKey);
    }

    /**
     * Returns errors messages container.
     *
     * @return MessageBag
     */
    public function errors() : MessageBag
    {
        return $this->messages;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    protected function isEmpty($value) : bool
    {
        return (new Required)->passes($value) === false;
    }

    /**
     * @param Attribute $attribute
     *
     * @return bool
     */
    protected function isOptional(Attribute $attribute) : bool
    {
        return $attribute->isRequired() === false;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    protected function stringify($value)
    {
        if (is_string($value) || is_numeric($value)) {
            return $value;
        } else if (is_array($value) || is_object($value)) {
            return json_encode($value);
        } else {
            return '';
        }
    }

    /**
     *
     * Parse data array.
     *
     * @param array $data
     *
     * @return array
     */
    protected function parseData(array $data)
    {
        $parsedData = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->parseData($value);
            }

            $parsedData[$key] = $value;
        }

        return $parsedData;
    }

    /**
     * Set the validation rules.
     *
     * @param array $rules
     *
     * @return void
     */
    public function setRules(array $rules)
    {
        foreach ($rules as $attribute => $appliedRules) {
            $parsedRules = (new RulesParser($this))->resolve($appliedRules);

            $this->attributes[$attribute] = new Attribute(
                $attribute,
                $parsedRules->resolved,
                $parsedRules->isRequired
            );
        }
    }

    /**
     * @return void
     */
    protected function registerDefaultValidators()
    {
        $validators = [
            Boolean::class,
            Date::class,
            DateAfter::class,
            DateBefore::class,
            Max::class,
            Min::class,
            Required::class
        ];

        foreach ($validators as $validator) {
            $this->setRuleValidator(new $validator);
        }
    }

    /**
     * @param Rule $rule
     *
     * @return void
     */
    public function setRuleValidator(Rule $rule)
    {
        $this->validators[$rule->getSlug()] = $rule;
    }

    /**
     * @param string $ruleKey
     *
     * @return mixed|null
     */
    public function getRuleValidator(string $ruleKey)
    {
        return $this->validators[$ruleKey] ?? null;
    }
}
