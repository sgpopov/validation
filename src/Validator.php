<?php

namespace svil4ok\Validator;

use svil4ok\Validator\Contracts\Rule;
use svil4ok\Validator\Rules\Min;
use svil4ok\Validator\Rules\Required;

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
     * @param string $attribute
     *
     * @return mixed|null
     */
    protected function getValue($attribute)
    {
        if (array_key_exists($attribute, $this->data)) {
            return $this->data[$attribute];
        }

        return null;
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
        } else if(is_array($value) || is_object($value)) {
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
            Required::class,
            Min::class
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
    public function getRuleValidator($ruleKey)
    {
        return $this->validators[$ruleKey] ?? null;
    }

    /**
     * @param string $rule
     *
     * @return Rule
     *
     * @throws \Exception
     */
    public function __invoke($rule)
    {
        $args = func_get_args();
        $rule = array_shift($args);
        $params = $args;

        $validator = $this->getRuleValidator($rule);

        if (!$validator) {
            throw new \Exception("Validator for '{$rule}' rule is not registered!");
        }

        $cloned = clone $validator;
        $cloned->setParams($params);

        return $cloned;
    }
}
