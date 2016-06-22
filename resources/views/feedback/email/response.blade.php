[ Note: This E-mail has been generated from the feedback form filled by the customer ]

--------------------------------------------------------------------------------
                                FEEDBACK
--------------------------------------------------------------------------------

<p><strong>Customer Name:</strong> {{ $feedback->name }}</p>

<p><strong>Customer Email:</strong> {{ $feedback->email }}</p>

<p>
    <strong>1. What happened that was unsatisfactory?</strong><br/>

    {{ $feedback->reason }}
</p>

<p>
    <strong>2. How can we make it better so this won’t happen again?</strong><br/>

    @if(!empty($feedback->suggestion))
        {{ $feedback->suggestion }}
    @else
        [ No feedback given on this question ]
    @endif
</p>

<p><strong>Campaign Details</strong></p>
<p>
    <strong>Name:</strong> {{ $campaign->name }}<br/>
    <strong>Product Title:</strong> {{ $campaign->product->title }}<br/>
</p>

--------------------------------------------------------------------------------
<p>Thank you,</p>
<p>WTC-Automation Service Team</p>