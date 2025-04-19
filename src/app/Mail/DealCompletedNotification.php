<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\User;

class DealCompletedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;
    public $item;
    public $buyer;

    /**
     * Create a new message instance.
     */
    public function __construct(Purchase $purchase, Item $item, User $buyer)
    {
        $this->purchase = $purchase;
        $this->item = $item;
        $this->buyer = $buyer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '商品取引完了のお知らせ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.deal_completed',
            with: [
                'purchase' => $this->purchase,
                'item' => $this->item,
                'buyer' => $this->buyer,
            ],
            // view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
