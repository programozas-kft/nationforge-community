<?php

return [
    'event_registration' => [
        'subject'        => 'Registration confirmation — :event',
        'header_sub'     => 'Thank you for registering!',
        'greeting'       => 'Dear :name,',
        'intro'          => 'You have successfully registered for the event: :event. Below is a summary of the details.',
        'when'           => 'When',
        'where'          => 'Where',
        'fee'            => 'Admission fee',
        'online_event'   => 'Online event',
        'your_details'   => 'Your submitted details',
        'guests'         => 'Guests',
        'view_event'     => 'View event',
        'outro'          => 'If you have any questions, simply reply to this email. We look forward to seeing you!',
        'footer_note'    => 'You received this email because you registered for an event in our system.',
    ],
    'waitlist' => [
        'subject'              => 'You\'re on the waiting list — :event',
        'header_sub'           => 'Waiting list confirmation',
        'intro'                => 'You have successfully joined the waiting list for: :event.',
        'position_label'       => 'Waiting list position',
        'position_note'        => 'If a spot opens up, we will notify you automatically by email.',
        'outro'                => 'If you no longer wish to wait, simply ignore this email — no further action is needed.',
        'promotion_subject'    => 'A spot opened up — :event',
        'promotion_header_sub' => 'Great news — a spot is available for you!',
        'promotion_intro'      => 'We\'re happy to inform you that a spot has opened up for: :event',
        'promotion_body'       => 'You have been moved to the confirmed attendee list. You can access your ticket using the button below.',
    ],
];
