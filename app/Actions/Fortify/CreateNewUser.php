<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Local;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Position;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
//use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'ruc' => ['required', 'string', 'max:255'],
            'razonsocial' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        //creando la empresa company
        $company = Company::create([
            'ruc' => strtoupper($input['ruc']),
            'razonsocial' => strtoupper($input['razonsocial']),
        ]);

        //creando local principal de company
        $local = Local::create([
            'name' => 'LOCAL PRINCIPAL',
            'company_id' => $company->id,
        ]);

        //creando el user
        $user = User::create([
            'name' => strtoupper($input['name']),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        //darle a user el admin
        $user->assignRole('Admin');

        //creando positions
        $position = Position::create([
            'name' => 'admin',
            'company_id' => $company->id,
        ]);


        //creando el employee
        Employee::create([
            'user_id' => $user->id,
            'local_id' => $local->id,
            'company_id' => $company->id,
            'position_id' => $position->id,
        ]);

        return $user;
    }
}
