<?php

return [
    'success.account.created' => 'Account created successfully!',
    'success.login' => 'Login successful',
    'error.invalid.credentials' => 'Invalid credentials',
    'error.phone.exists' => 'This phone number already exists',
    'error.csrf.invalid' => 'Invalid CSRF token',
    'error.upload.failed' => 'Upload failed',
    'error.validation.failed' => 'Invalid data',
    'validation.required' => 'The :field field is required',
    'validation.email' => 'The :field field must be a valid email',
    'validation.phone' => 'Phone number must be in Senegalese format',
    'validation.cni' => 'CNI number must be in Senegalese format',
    'error.upload.generic' => 'An unknown error occurred during file upload',
    'error.upload.size' => 'File is too large (max: 2MB)',
    'error.upload.type' => 'Unauthorized file type (JPG, PNG only)',
    'error.upload.save' => 'Error saving file',
    
    // New messages for transactions
    'success.deposit' => 'Deposit successful!',
    'error.deposit.failed' => 'Deposit failed. Please try again.',
    'error.invalid.amount' => 'Amount must be greater than zero.',
    'error.account.not_found' => 'Account not found.',
    'error.transaction.save_failed' => 'Error saving transaction.',
    'error.transaction.fetch' => 'Error fetching transactions.',
    'error.deposit.form_load' => 'Error loading deposit form.',
    'validation.min' => 'The :field field must be at least :min.',
];
