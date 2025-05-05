@props(['categories', 'selected' => []])

<div class="flex flex-col gap-4" x-data="categorySelector({{ \Illuminate\Support\Js::from($categories) }}, {{ \Illuminate\Support\Js::from($selected) }})">
    <input 
        type="search" 
        placeholder="Search category" 
        class="focus:outline-none focus:ring-0 bg-zinc-50 border border-slate-400"
        x-model="search"
    />
    <div class="space-y-2 max-h-64 overflow-y-auto">
        <template x-for="category in filteredCategories" :key="category.id">
            <label class="flex items-center space-x-2">
                <input 
                    type="checkbox" 
                    name="categories[]" 
                    :value="category.id" 
                    :checked="selected.includes(category.id)"
                    @change="toggleSelection(category.id)"
                    class="form-checkbox text-blue-600 rounded-none focus:outline-none focus:ring-0"
                >
                <span x-text="category.name"></span>
            </label>
        </template>
    </div>
</div>

<script>
    function categorySelector(categories, selected) {
        return {
            categories: categories,
            selected: selected,
            search: '',
            get filteredCategories() {
                if (!this.search) return this.categories;
                return this.categories.filter(cat =>
                    cat.name.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            toggleSelection(id) {
                if (this.selected.includes(id)) {
                    this.selected = this.selected.filter(item => item !== id);
                } else {
                    this.selected.push(id);
                }
            }
        };
    }
</script>
