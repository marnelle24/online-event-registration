<ul class="mt-4 flex flex-col gap-2.5">
    <!-- Check if the $data is available -->
     @isset($data) 
        @foreach($data as $item)
            <li class="">
                <a wire:navigate 
                    href="{{route('admin.programme-item', $item->slug)}}" 
                    class="{{ Route::current()->getName() === 'admin.'.$item->slug.'-profile' || (Route::current()->getName() === 'admin.programme-item' && Route::current()->parameters()['program_slug'] === $item->slug) ? 'bg-graydark dark:bg-meta-4' : '' }} capitalize pl-10 py-2 group relative flex items-center gap-1 rounded-none font-medium text-white hover:bg-graydark dark:hover:bg-meta-4 duration-300 ease-in-out">
                    {{ $item->name }}
                    {{-- {{ Route::current()->getName() }} --}}
                    {{-- admin.{{$item->slug}}-profile --}}
                </a>
            </li> 
        @endforeach
    @endisset
</ul>