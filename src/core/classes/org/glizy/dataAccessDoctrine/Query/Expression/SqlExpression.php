<?php

class org_glizy_dataAccessDoctrine_Query_Expression_SqlExpression
{
    protected $value;

    /**
     * Initializes a new <tt>SqlExpression</tt>.
     *
     * @param SQL string
     */
    public function __construct($value)
    {
        $this->value =  $value;
    }


    /**
     * Retrieve the string representation of expression.
     *
     * @return string
     */
    public function __toString()
    {
        if (count($this->parts) === 1) {
            return (string) $this->parts[0];
        }

        return '(' . $this->value . ')';
    }
}
