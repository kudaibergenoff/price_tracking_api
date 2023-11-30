<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserProductMail extends Mailable
{
	use Queueable, SerializesModels;

	public string $notification;

	/**
	 * Create a new message instance.
	 */
	public function __construct(string $notification)
	{
		$this->notification = $notification;
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			subject: 'Изменений в ценах на товар',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			markdown: 'email.product-price',
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, Attachment>
	 */
	public function attachments(): array
	{
		return [];
	}

	public function build(): UserProductMail
	{
		return $this->subject("Изменений в ценах на товар")->markdown('email.product-price');
	}
}
