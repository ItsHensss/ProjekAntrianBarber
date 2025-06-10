<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Models\Queue;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;

class TransaksiReport extends Page
{
    use WithPagination;

    protected static string $resource = \App\Filament\Resources\TransaksiResource::class;
    protected static string $view = 'filament.resources.transaksi-resource.pages.transaksi-report';

    public $from;
    public $until;
    public $data = [];

    public function mount(): void
    {
        $this->from = now()->startOfMonth()->toDateString();
        $this->until = now()->endOfMonth()->toDateString();

        $this->data = $this->getData();
    }

    public function getData()
    {
        $from = Carbon::parse($this->from)->startOfDay();
        $until = Carbon::parse($this->until)->startOfDay()->addDay(); // agar inklusif

        return Queue::with(['user', 'produk', 'customer'])
            ->whereBetween('booking_date', [$from->toDateString(), $until->subDay()->toDateString()])
            ->orderBy('booking_date', 'asc')
            ->get();
    }

    public function updatedFrom()
    {
        $this->data = $this->getData();
    }
    public function updatedUntil()
    {
        $this->data = $this->getData();
    }
}
