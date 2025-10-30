<select 
    name="{{ $name }}" 
    id="{{ $id }}" 
    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary {{ $class }}"
    @if($required) required @endif
>
    <option value="">{{ $placeholder }}</option>
    @foreach($countries as $code => $name)
        @if($code === '---')
            <option disabled>──────────────</option>
        @else
            <option value="{{ $code }}" {{ $selected == $code ? 'selected' : '' }}>
                {!! $name !!}
            </option>
        @endif
    @endforeach
</select>
