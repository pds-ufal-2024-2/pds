<div>
    <form wire:submit="savePhoto">
        <input type="file" wire:model="photo">
        @error('photo') <span class="error">{{ $message }}</span> @enderror

        <button type="submit">Save photo</button>
    </form>
</div>
