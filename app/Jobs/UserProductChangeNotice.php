<?php

namespace App\Jobs;

use App\Mail\UserProductMail;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserProductChangeNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $getSubscribedEmails = UserProduct::query()
            ->with(['user'])
            ->where('product_id', '=', $this->product->id)
            ->get()
            ->pluck('user.email')
            ->unique()
            ->toArray();

        $notification = sprintf(
            'Произошли изменения в ценах на товар: %s, Цена: %s тг',
            $this->product->name,
            $this->product->price
        );

        foreach ($getSubscribedEmails as $email) {
            Mail::to($email)->send(new UserProductMail($notification));
        }
    }
}
