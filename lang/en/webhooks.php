<?php

return [
    'title'              => 'Webhooks',
    'subtitle'           => 'Outgoing HTTP notifications to external systems on system events.',
    'add_btn'            => 'Add Webhook',
    'active'             => 'Active',
    'inactive'           => 'Inactive',
    'last_ok'            => 'Last: OK',
    'last_failed'        => 'Last: Failed',
    'deliveries_btn'     => 'Deliveries',
    'activate'           => 'Activate',
    'deactivate'         => 'Deactivate',
    'confirm_delete'     => 'Are you sure you want to delete this webhook?',
    'empty'              => 'No webhooks configured yet.',

    'modal_create_title' => 'New Webhook',
    'modal_edit_title'   => 'Edit Webhook',

    'field_name'         => 'Name',
    'field_url'          => 'Target URL',
    'field_secret'       => 'Signing Secret (HMAC)',
    'field_events'       => 'Subscribed Events',
    'name_placeholder'   => 'e.g. CRM integration',
    'secret_placeholder' => 'Optional — used for signature verification',
    'secret_hint'        => 'If provided, every request will include an X-NationForge-Signature header (HMAC-SHA256).',

    'created'            => 'Webhook created.',
    'updated'            => 'Webhook updated.',
    'deleted'            => 'Webhook deleted.',
    'retry_queued'       => 'Retry queued.',

    'deliveries_title'   => 'Delivery Log',
    'col_event'          => 'Event',
    'col_status'         => 'Status',
    'col_code'           => 'HTTP Code',
    'col_attempt'        => 'Attempt',
    'col_date'           => 'Date',
    'status_success'     => 'Success',
    'status_failed'      => 'Failed',
    'status_pending'     => 'Pending',
    'retry_btn'          => 'Retry',
    'no_deliveries'      => 'No deliveries yet.',
];
