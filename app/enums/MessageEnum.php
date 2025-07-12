<?php

class MessageEnum
{
    const SUCCESS_ACCOUNT_CREATED = 'success.account.created';
    const SUCCESS_LOGIN = 'success.login';
    const ERROR_INVALID_CREDENTIALS = 'error.invalid.credentials';
    const ERROR_PHONE_EXISTS = 'error.phone.exists';
    const ERROR_CSRF_INVALID = 'error.csrf.invalid';
    const ERROR_UPLOAD_FAILED = 'error.upload.failed';
    const ERROR_VALIDATION_FAILED = 'error.validation.failed';
    const ERROR_UPLOAD_GENERIC = 'error.upload.generic';
    const ERROR_UPLOAD_SIZE = 'error.upload.size';
    const ERROR_UPLOAD_TYPE = 'error.upload.type';
    const ERROR_UPLOAD_SAVE = 'error.upload.save';
    
    // Nouveaux messages pour les transactions
    const SUCCESS_DEPOSIT = 'success.deposit';
    const ERROR_DEPOSIT_FAILED = 'error.deposit.failed';
    const ERROR_INVALID_AMOUNT = 'error.invalid.amount';
    const ERROR_ACCOUNT_NOT_FOUND = 'error.account.not_found';
    const ERROR_TRANSACTION_SAVE_FAILED = 'error.transaction.save_failed';
    const ERROR_TRANSACTION_FETCH = 'error.transaction.fetch';
    const ERROR_DEPOSIT_FORM_LOAD = 'error.deposit.form_load';
}
