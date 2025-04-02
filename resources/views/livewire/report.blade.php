<div>
    <form wire:submit="savePhoto">
        <input type="file" wire:model="photo">
        @error('photo') <span class="error">{{ $message }}</span> @enderror

        <button type="submit">Save photo</button>

        @if ($photo)
            <img src="{{ $photo->temporaryUrl() }}" alt="Photo preview" style="max-width: 200px; max-height: 200px;">
        @endif

        <div wire:loading wire:target="photo">Uploading...</div>
        <div wire:loading.remove wire:target="photo">
            @if ($photo)
                <p>Photo uploaded successfully!</p>
            @endif
        </div>
        <div wire:loading wire:target="savePhoto">Saving...</div>
        <div wire:loading.remove wire:target="savePhoto">
            @if ($photo)
                <p>Photo saved successfully!</p>
            @endif
        </div>
        {{ $photoDetailsRaw }}
    </form>
</div>
