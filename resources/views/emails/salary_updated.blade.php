<p>Dear {{ $salary->instructor_id ? $salary->instructor->name : 'Staff' }},</p>

<p>Your salary has been  <strong>{{ ucfirst($salary->salary_status) }}</strong>.</p>

<ul>
    <li><strong>Reference No:</strong> {{ $salary->reference_no }}</li>
    <li><strong>Amount:</strong> {{ $salary->paid_amount }}</li>
    <li><strong>Method:</strong> {{ $salary->paid_method }}</li>
    <li><strong>Date:</strong> {{ $salary->paid_date->format('F d, Y') }}</li>
</ul>

<p>Thank you.</p>