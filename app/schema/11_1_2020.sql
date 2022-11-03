ALTER TABLE
    `job_applications`
MODIFY COLUMN
    `status` enum(
        'pending', 'passed', 'failed' , 'cancelled' , 'denied'
    );

ALTER TABLE
    `job_applications`
MODIFY COLUMN
    `status_label` enum(
        'pending','interview','endorsed','complete','failed', 'cancelled' , 'denied'
    );