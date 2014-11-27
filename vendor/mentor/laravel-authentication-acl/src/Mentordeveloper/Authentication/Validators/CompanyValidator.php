<?php namespace Mentordeveloper\Authentication\Validators;

use Mentordeveloper\Library\Validators\OverrideConnectionValidator;
use Event;


class CompanyValidator extends OverrideConnectionValidator
{
    protected static $rules = [
        "email" => ["required", "email"],
        "c_name" => ["required"],
        "emp_name" => ["required"],
        "emp_number" => ["required","min:8"],
        "address" => ["required"],
        "contact_number" => ["required"],
        "password" => ["confirmed"]
    ];

    public function __construct()
    {
        Event::listen('validating', function($input)
        {
            // check if the input comes form the correct form
            if(!isset($input['form_name']) || $input['form_name']!='client')
                return true;

            if(empty($input["id"]))
            {
                static::$rules["password"][] = "required";
                static::$rules["email"][] = "unique:clients,username";
                static::$rules["c_name"][] = "unique:clients,company_name";
                static::$rules["emp_name"][] = "required";
                static::$rules["emp_number"][] = "required";
                static::$rules["address"][] = "required";
                static::$rules["contact_number"][] = "required";
            }
            else
            {
                static::$rules["email"][] = "unique:clients,email,{$input['id']}";
                static::$rules["c_name"][] = "unique:clients,company_name,{$input['id']}";
            }
        });

        // make unique keys for email and password
        static::$rules["email"] = array_unique(static::$rules["email"]);
        static::$rules["c_name"] = array_unique(static::$rules["c_name"]);
        static::$rules["emp_name"] = array_unique(static::$rules["emp_name"]);
        static::$rules["emp_number"] = array_unique(static::$rules["address"]);
        static::$rules["contact_number"] = array_unique(static::$rules["contact_number"]);
        static::$rules["address"] = array_unique(static::$rules["emp_number"]);
        static::$rules["password"] = array_unique(static::$rules["password"]);
    }

    /**
     * User to reset static rules to default values
     */
    public static function resetStatic()
    {
        static::$rules = [
                "email" => ["required", "email"],
                "c_name" => ["required"],
                "emp_name" => ["required"],
                "emp_number" => ["required"],
                "contact_number" => ["required"],
                "address" => ["required"],
                "password" => ["confirmed"]
        ];
    }
} 