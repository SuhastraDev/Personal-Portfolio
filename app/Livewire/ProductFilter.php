<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Livewire\Component;
use Livewire\WithPagination;

class ProductFilter extends Component
{
    use WithPagination;

    public ?int $categoryId = null;
    public ?int $tagId = null;
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function filterCategory(?int $id): void
    {
        $this->categoryId = $this->categoryId === $id ? null : $id;
        $this->resetPage();
    }

    public function filterTag(?int $id): void
    {
        $this->tagId = $this->tagId === $id ? null : $id;
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::active()->with('category', 'tags')->latest();

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->tagId) {
            $query->whereHas('tags', function ($q) {
                $q->where('product_tags.id', $this->tagId);
            });
        }

        if ($this->search) {
            $escaped = str_replace(['%', '_'], ['\%', '\_'], $this->search);
            $query->where(function ($q) use ($escaped) {
                $q->where('title', 'like', "%{$escaped}%")
                    ->orWhere('description', 'like', "%{$escaped}%");
            });
        }

        return view('livewire.product-filter', [
            'products' => $query->paginate(12),
            'categories' => ProductCategory::orderBy('name')->get(),
            'tags' => ProductTag::orderBy('name')->get(),
        ]);
    }
}
