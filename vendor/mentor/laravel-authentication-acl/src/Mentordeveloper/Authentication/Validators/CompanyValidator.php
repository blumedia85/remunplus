<?php namespace Mentordeveloper\Authentication\Validators;

use Mentordeveloper\Library\Validators\OverrideConnectionValidator;
use Event;


class CompanyValidator extends OverrideConnectionValidator
{
    protected static $rules = [
        "email" => ["required", "email"],
        "password" => ["confirmed"],
        "company_name" => ["required"],
        "employer_name" => ["required"],
        "employer_number" => ["required","min:8"],
        "address" => ["required"],
        "contact_number" => ["required"],
        "start_date" => ["required"],
        "end_date" => ["required"],
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
                static::$rules["company_name"][] = "unique:clients,company_name";
                static::$rules["employer_name"][] = "required";
                static::$rules["employer_number"][] = "required";
                static::$rules["address"][] = "required";
                static::$rules["contact_number"][] = "required";
                static::$rules["start_date"][] = "required";
                static::$rules["end_date"][] = "required";
            }
            else
            {
                static::$rules["email"][] = "unique:clients,email,{$input['id']}";
                static::$rules["company_name"][] = "unique:clients,company_name,{$input['id']}";
            }
        });

        // make unique keys for email and password
        static::$rules["email"] = array_unique(static::$rules["email"]);
        static::$rules["password"] = array_unique(static::$rules["password"]);
        static::$rules["company_name"] = array_unique(static::$rules["company_name"]);
        static::$rules["employer_name"] = array_unique(static::$rules["employer_name"]);
        static::$rules["employer_number"] = array_unique(static::$rules["employer_number"]);
        static::$rules["contact_number"] = array_unique(static::$rules["contact_number"]);
        static::$rules["address"] = array_unique(static::$rules["address"]);
        static::$rules["start_date"] = array_unique(static::$rules["start_date"]);
        static::$rules["end_date"] = array_unique(static::$rules["end_date"]);
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