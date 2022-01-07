<div>
    <input wire:model="username" type="text" placeholder="Search users..."/><br>

   @php
       foreach(json_decode($usuario)->users as $user){
            $this->usuario = $user->fullname;
        }
   @endphp
</div>
