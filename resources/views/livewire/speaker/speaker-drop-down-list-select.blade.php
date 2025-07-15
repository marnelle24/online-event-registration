<div>
    <x-validation-errors class="mb-4" />
    <div class="flex flex-col gap-4">
        <div>
            <p class="text-sm mb-1">Find the existing speaker or professional</p>
            <select wire:model="speakerID" class="focus:ring-0 focus:border-slate-600 min-h-12 w-full rounded-none bg-slate-100 border border-slate-400">
                <option value="" selected>Select Professional</option>
                @foreach($speakers as $speaker)
                    <option value="{{$speaker->id}}" class="capitalize">
                        {{$speaker->name}} - {{ $speaker->profession}}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <p class="text-sm mb-1">What's the function of the professional in the programme?</p>
            <select wire:model="type" class="focus:ring-0 focus:border-slate-600 min-h-12 w-full rounded-none bg-slate-100 border border-slate-400">
                <option value="" selected>Assign as</option>
                <option value="speaker">Speaker</option>
                <option value="trainer">Trainer</option>
                <option value="facilitator">Facilitator</option>
                <option value="others">Other</option>
            </select>
        </div>
        <div>
            <p class="text-sm mb-1">What's the topic or short details of the role?</p>
            <textarea 
                wire:model="details"
                rows="4" 
                class="focus:ring-0 focus:border-slate-600 min-h-12 w-full rounded-none bg-slate-100 border border-slate-400" placeholder="Topic or short details of the role"></textarea>
        </div>
        <button 
            type="button"
            wire:target="saveChanges"
            wire:loading.attr="disabled"
            wire:click="saveChanges" 
            class="disabled:cursor-not-allowed disabled:opacity-50 flex w-full justify-center items-center text-white bg-green-600 hover:bg-green-700 duration-300 drop-shadow bg-opacity-90 uppercase py-3 text-lg">
            <span wire:loading.remove wire:target="saveChanges">
                Save
            </span>
            <span wire:loading wire:target="saveChanges">
                Saving...
            </span>
        </button>
    </div>
</div>
