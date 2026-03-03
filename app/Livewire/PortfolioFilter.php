<?php

namespace App\Livewire;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Livewire\Component;
use Livewire\WithPagination;

class PortfolioFilter extends Component
{
    use WithPagination;

    public ?int $categoryId = null;

    public function updatedCategoryId(): void
    {
        $this->resetPage();
    }

    public function filterCategory(?int $id): void
    {
        $this->categoryId = $this->categoryId === $id ? null : $id;
        $this->resetPage();
    }

    public function render()
    {
        $query = Portfolio::with('categories')->latest();

        if ($this->categoryId) {
            $query->whereHas('categories', function ($q) {
                $q->where('portfolio_categories.id', $this->categoryId);
            });
        }

        return view('livewire.portfolio-filter', [
            'portfolios' => $query->paginate(12),
            'categories' => PortfolioCategory::orderBy('name')->get(),
        ]);
    }
}
