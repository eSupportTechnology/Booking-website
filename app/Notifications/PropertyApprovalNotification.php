<?php

namespace App\Notifications;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PropertyApprovalNotification extends Notification
{
    use Queueable;

    public function __construct(private Property $property)
    {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $status = $this->property->status;
        $message = $status === 'approved'
            ? "Your property '{$this->property->name}' has been approved and is now live on our platform."
            : "Your property '{$this->property->name}' has been rejected. Reason: {$this->property->rejection_reason}";

        return (new MailMessage)
            ->subject("Property {$status}")
            ->line($message)
            ->action(
                'View Property',
                route('partner.properties.views', $this->property->id)
            );
    }

    public function toArray($notifiable): array
    {
        return [
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'status' => $this->property->status,
            'reason' => $this->property->rejection_reason,
        ];
    }
}
