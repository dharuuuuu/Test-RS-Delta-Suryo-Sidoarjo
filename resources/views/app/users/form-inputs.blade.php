@php $editing = isset($user) @endphp

<div class="flex flex-wrap -mx-4">
    <div class="w-full md:w-full px-4">
        <x-inputs.group class="w-full">
            <x-inputs.text
                name="name"
                label="Full Name"
                :value="old('name', ($editing ? $user->name : ''))"
                maxlength="255"
                placeholder="Full Name"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.email
                name="email"
                label="Email"
                :value="old('email', ($editing ? $user->email : ''))"
                maxlength="255"
                placeholder="Email"
                required
            ></x-inputs.email>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.password
                name="password"
                label="Password"
                maxlength="255"
                placeholder="Password"
                :required="!$editing"
            ></x-inputs.password>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.select name="gender" label="Gender">
                @php $selected = old('gender', ($editing ? $user->gender : '')) @endphp
                <option value="Laki-Laki" {{ $selected == 'Laki-Laki' ? 'selected' : '' }}>Male</option>
                <option value="Perempuan" {{ $selected == 'Perempuan' ? 'selected' : '' }}>Female</option>
            </x-inputs.select>
        </x-inputs.group>
    </div>

    <div class="w-full md:w-1/2 px-4">
        <x-inputs.group class="w-full">
            <x-inputs.date
                name="date_of_birth"
                label="Date of Birth"
                value="{{ old('date_of_birth', ($editing ? optional($user->date_of_birth)->format('Y-m-d') : '')) }}"
                max="255"
                required
            ></x-inputs.date>
        </x-inputs.group>
    </div>
</div>

{{-- Role Selection (Full Width) --}}
<div class="px-4 my-4 w-full">
    <h4 class="font-bold text-lg text-gray-700">
        Assign @lang('crud.roles.name')
    </h4>

    <div class="py-2 flex flex-wrap gap-4">
        @foreach ($roles as $role)
        <div class="w-auto">
            <x-inputs.checkbox
                id="role{{ $role->id }}"
                name="roles[]"
                label="{{ ucfirst($role->name) }}"
                value="{{ $role->id }}"
                :checked="isset($user) ? $user->hasRole($role) : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
