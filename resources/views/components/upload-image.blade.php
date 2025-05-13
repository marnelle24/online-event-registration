@props([
    'label' => 'Image',
    'name' => 'image',
    'emptyLabel' => 'No Image',
    'defaultImage' => null,
])

<div class="flex flex-col" x-data="inputImage('{{$defaultImage}}')">
    <!-- Preview -->
    <label class="block mb-1 font-semibold">{{ $label }}</label>
    <div 
        :class="{ 'border-2 border-dashed' : !imagePreview }"
        {!! $attributes->merge(['class' => 'mb-4 flex justify-center items-center']) !!} x-transition
    >
        <p x-show="!imagePreview" class="text-zinc-400 drop-shadow-sm text-2xl uppercase font-bold">{{ $emptyLabel}}</p>
        <div x-show="imagePreview">
            <img :src="imagePreview" alt="Image Preview" class="w-full h-auto rounded border border-gray-300">
        </div>
    </div>
    <input type="file" name="{{ $name }}" accept="image/*" @change="previewImage" class="file:border-slate-200 file:bg-slate-200 file:border-none file:p-2 file:text-sm w-full border border-slate-400 bg-zinc-100">
</div>

<script>
    function inputImage(defaultImage = NULL) 
    {
        return {
            imagePreview: defaultImage,
            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
                }
            },
        }
    }
</script>