<div class="mb-3">
    {{-- Care about people's approval and you will be their prisoner. --}}
    <input type="file" wire:model="image" name="comprobante_imagen" accept="image/*">
    @error('comprobante_imagen')
    <span class="text-danger">{{$message}}</span>
    @enderror
</div>
