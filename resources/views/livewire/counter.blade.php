<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>

    <input wire:model="name" type="text"><br>
    こんにちは {{ $name }} さん

</div>