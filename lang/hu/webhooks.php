<?php

return [
    'title'              => 'Webhook-ok',
    'subtitle'           => 'Kimenő HTTP értesítések külső rendszerek felé rendszeresemények esetén.',
    'add_btn'            => 'Webhook hozzáadása',
    'active'             => 'Aktív',
    'inactive'           => 'Inaktív',
    'last_ok'            => 'Utolsó: OK',
    'last_failed'        => 'Utolsó: Hiba',
    'deliveries_btn'     => 'Küldések',
    'activate'           => 'Aktiválás',
    'deactivate'         => 'Letiltás',
    'confirm_delete'     => 'Biztosan törlöd ezt a webhook-ot?',
    'empty'              => 'Még nincs webhook konfigurálva.',

    'modal_create_title' => 'Új webhook',
    'modal_edit_title'   => 'Webhook szerkesztése',

    'field_name'         => 'Név',
    'field_url'          => 'Cél URL',
    'field_secret'       => 'Titkos kulcs (HMAC)',
    'field_events'       => 'Feliratkozott eseményekre',
    'name_placeholder'   => 'pl. CRM integráció',
    'secret_placeholder' => 'Opcionális — az aláírás ellenőrzéséhez',
    'secret_hint'        => 'Ha megadod, az X-NationForge-Signature fejléc HMAC-SHA256 aláírással lesz ellátva.',

    'created'            => 'Webhook létrehozva.',
    'updated'            => 'Webhook frissítve.',
    'deleted'            => 'Webhook törölve.',
    'retry_queued'       => 'Újrapróbálás elindítva.',

    'deliveries_title'   => 'Küldési napló',
    'col_event'          => 'Esemény',
    'col_status'         => 'Státusz',
    'col_code'           => 'HTTP kód',
    'col_attempt'        => 'Próbálkozás',
    'col_date'           => 'Időpont',
    'status_success'     => 'Sikeres',
    'status_failed'      => 'Sikertelen',
    'status_pending'     => 'Folyamatban',
    'retry_btn'          => 'Újra',
    'no_deliveries'      => 'Még nem történt küldés.',
];
