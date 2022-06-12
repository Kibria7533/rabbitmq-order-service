<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
abstract class BaseModel extends Model
{


    public const COMMON_GUARDED_FIELDS_SIMPLE = ['id', 'created_at', 'updated_at'];
    public const COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE = ['id', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_NON_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    /** Client Url End Point Type*/
    public const ORGANIZATION_CLIENT_URL_TYPE = "ORGANIZATION";
    public const INSTITUTE_URL_CLIENT_TYPE = "INSTITUTE";
    public const CORE_CLIENT_URL_TYPE = "CORE";
    public const YOUTH_CLIENT_URL_TYPE = "YOUTH";
    public const CMS_CLIENT_URL_TYPE = "CMS";
    public const IDP_SERVER_CLIENT_PROFILE_URL_TYPE = "IDP_SERVER_USER";
    public const IDP_SERVER_CLIENT_BASE_URL_TYPE = "IDP_SERVER";

    /** Youth Row Statues  */
    public const ROW_STATUS_INACTIVE = 0;
    public const ROW_STATUS_ACTIVE = 1;
    public const ROW_STATUS_PENDING = 2;
    public const ROW_STATUS_REJECTED = 3;

    /** Row Status */
    public const ROW_ORDER_ASC = 'ASC';
    public const ROW_ORDER_DESC = 'DESC';

    /** Youth User Type */
    public const YOUTH_USER_TYPE = 4;

    /** True False Flag */
    public const TRUE = 1;
    public const FALSE = 0;

    /** Freelance Status */
    public const FREELANCE_PROFILE_YES = self::TRUE;
    public const FREELANCE_PROFILE_NO = self::FALSE;
    public const FREELANCE_PROFILE_STATUS = [
        self::FREELANCE_PROFILE_YES,
        self::FREELANCE_PROFILE_NO
    ];

    /** Physical Disability Statues  */
    public const PHYSICAL_DISABILITIES_STATUSES = [
        self::TRUE,
        self::FALSE
    ];

    /** Gender Statuses */
    public const MALE = 1;
    public const FEMALE = 2;
    public const OTHERS = 3;
    public const GENDERS = [
        self::MALE,
        self::FEMALE,
        self::OTHERS
    ];

    /** BIRTHDATE FORMAT  */
    public const BIRTHDATE_FORMAT = "Y-m-d";

    /** MOBILE REGEX  */
    public const MOBILE_REGEX = 'regex: /^(01[3-9]\d{8})$/';


    /** Password Validation Rules */
    /** Password Regex
     * Regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/
     * Means:
     * 1) Should have At least one Uppercase letter.
     * 2) At least one Lower case letter.
     * 3) Also,At least one numeric value.
     * 4) And, At least one special character.
     * 5) Must be more than 8 characters long.
     */
    public const PASSWORD_REGEX = "regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
    public const PASSWORD_TYPE = "string";
    public const PASSWORD_MIN_LENGTH = "min:8";
    public const PASSWORD_MIN_LENGTH_V1 = 8;
    public const PASSWORD_MAX_LENGTH = "max:50";
    public const PASSWORD_MAX_LENGTH_V1 = 50;

    /** UserName Type */
    public const USER_NAME_TYPE_EMAIL = 1;
    public const USER_NAME_TYPE_MOBILE_NUMBER = 2;
    public const USER_NAME_TYPES = [
        self::USER_NAME_TYPE_EMAIL,
        self::USER_NAME_TYPE_MOBILE_NUMBER
    ];

    public const DEFAULT_PAGE_SIZE = 10;

    public const SELF_EXCHANGE = 'order';

    public const NISE3_FROM_EMAIL = "noreply@nise.gov.bd";
    public const NISE3_DEFAULT_URL = "http://123.49.47.38/";

    /** Saga Status */
    public const SAGA_STATUS_CREATE_PENDING = 1;
    public const SAGA_STATUS_UPDATE_PENDING = 2;
    public const SAGA_STATUS_DESTROY_PENDING = 3;
    public const SAGA_STATUS_COMMIT = 4;
    public const SAGA_STATUS_ROLLBACK = 5;

    /** SAGA events Publisher & Consumer */
    public const SAGA_CORE_SERVICE = 'core_service';
    public const SAGA_INSTITUTE_SERVICE = 'institute_service';
    public const SAGA_ORGANIZATION_SERVICE = 'organization_service';
    public const SAGA_YOUTH_SERVICE = 'youth_service';
    public const SAGA_CMS_SERVICE = 'cms_service';
    public const SAGA_MAIL_SMS_SERVICE = 'mail_sms_service';

    public const DATABASE_CONNECTION_ERROR_CODE = 2002;

    /** Admin access type */
    public const ADMIN_ACCESS_TYPE_TRAINER_USER = 1;
    public const ADMIN_ACCESS_TYPES = [
        self::ADMIN_ACCESS_TYPE_TRAINER_USER
    ];
}
