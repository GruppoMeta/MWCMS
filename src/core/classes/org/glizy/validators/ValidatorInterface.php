<?php
/**
 * This file is part of the GLIZY framework.
 * Copyright (c) 2005-2012 Daniele Ugoletti <daniele.ugoletti@glizy.com>
 * 
 * For the full copyright and license information, please view the COPYRIGHT.txt
 * file that was distributed with this source code.
 */

interface org_glizy_validators_ValidatorInterface
{
    /**
     * @param string $description
     * @param string $value
     *
     * @return bool|string
     */
    public function validate($description, $value);
}
