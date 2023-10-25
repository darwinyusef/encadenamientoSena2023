<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Models\Student;
use App\Models\Selections;
use App\Models\Programs;

class StudentController extends Controller
{
    public function allRules(string $type = 'CREATED')
    {
        $validations = [
            'phone' => 'required|max_digits:16',
            'phone_attendant' => 'required|max_digits:16',
            'ie' => 'required',
            'register' => 'required',
            Rule::in(['INITIAL', 'REGISTER', 'SELECTION']),
        ];
        if ($type == 'CREATED') {
            $validations['allname'] = 'required';
            $validations['email'] = 'required|email|unique:students';
            $validations['document'] =
                'required|integer|unique:students|max_digits:15';
            $validations['typedocument'] = 'required';
            $send = $validations;
        } elseif ($type == 'EDITED') {
            $validations['email'] = 'required|email';
            $send = $validations;
        }

        return $send;
    }

    public function allMessages()
    {
        return [
            'document.unique' => 'El documento ya existe en la base de datos',
            'document.integer' => 'El documento solo puede ser un número',
            'allname.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El Email no es valido',
            'email.unique' =>
                'El Email actualmente ya existe en la base de datos',
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Student::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $rules = $this->allRules();
        $customMessage = $this->allMessages();
        $validation = Validator::make($req->all(), $rules, $customMessage);

        //here 422 means unprocessable entity
        if ($validation->fails()) {
            return response()->json(
                ['type' => 'error', 'message' => $validation->errors()],
                422
            );
        }

        Student::create([
            'allname' => $req->allname,
            'email' => $req->email,
            'uuid' => (string) Str::uuid(),
            'document' => $req->document,
            'typedocument' => $req->typedocument,
            'phone' => $req->phone,
            'phone_attendant' => $req->phone_attendant,
            'ie' => $req->ie,
            'active' => 1,
            'asistencia' => date('Y-m-d H:i:s'),
            'register' => 'CONNECTED',
        ]);

        return response()->json(
            ['type' => 'ok', 'message' => 'Student Created Successfully'],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req, string $uuid)
    {
        $students = Student::where('uuid', $uuid)->first();
        return response()->json($students);
    }

    /**
     * Display the specified resource.
     */
    public function search_document(Request $req, string $document)
    {
        $students = Student::where('document', $document)->first();
        if ($students != null) {
            return response()->json(
                [
                    'type' => 'ok',
                    'message' => 'Student as Search Successfully',
                    'data' => $students,
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'type' => 'error',
                    'message' => 'El estudiante no existe en la base de datos',
                    'data' => $students,
                ],
                201
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $uuid)
    {
        $rules = $this->allRules('EDITED');

        // Only validate email
        $onlyEmailValidate = Student::where('uuid', $uuid)->first();

        if ($onlyEmailValidate == null) {
            return response()->json(
                [
                    'type' => 'error',
                    'message' => 'Student dont exist in database',
                ],
                404
            );
        }

        if ($req->email == $onlyEmailValidate->email) {
            $rules['email'] = 'required';
        } else {
            $rules['email'] = 'required|email|unique:students';
        }
        $customMessage = $this->allMessages();
        $validation = Validator::make($req->all(), $rules, $customMessage);

        //here 422 means unprocessable entity
        if ($validation->fails()) {
            return response()->json(
                ['type' => 'error', 'message' => $validation->errors()],
                422
            );
        }

        $upStudent = Student::where('uuid', $uuid)->update([
            'email' => $req->email,
            'phone' => $req->phone,
            'phone_attendant' => $req->phone_attendant,
            'ie' => $req->ie,
            'active' => $req->active,
            'register' => 'CONNECTED',
        ]);

        $upStudentAll = Student::where('uuid', $uuid)->first();

        return response()->json(
            [
                'type' => 'ok',
                'message' => 'Student Update Successfully',
                'data' => $upStudentAll,
            ],
            201
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function asistencia(Request $req, string $uuid)
    {
        $rules = [
            'phone' => 'required|max_digits:16',
            'phone_attendant' => 'required|max_digits:16',
        ];

        // Only validate email
        $onlyEmailValidate = Student::where('uuid', $uuid)->first();

        if ($onlyEmailValidate == null) {
            return response()->json(
                [
                    'type' => 'error',
                    'message' => 'Student dont exist in database',
                ],
                404
            );
        }

        if ($req->email == $onlyEmailValidate->email) {
            $rules['email'] = 'required';
        } else {
            $rules['email'] = 'required|email|unique:students';
        }
        $customMessage = $this->allMessages();

        // las validaciones con email incluido
        $validation = Validator::make($req->all(), $rules, $customMessage);

        //here 422 means unprocessable entity
        if ($validation->fails()) {
            return response()->json(
                ['type' => 'error', 'message' => $validation->errors()],
                422
            );
        }

        if($req->accept) {
            $personal_data = date('Y-m-d H:i:s');
        } else {
            $personal_data = null; 
        }

        $upStudent = Student::where('uuid', $uuid)->update([
            'email' => $req->email,
            'phone' => $req->phone,
            'phone_attendant' => $req->phone_attendant,
            'personal_data' => $personal_data,
            'active' => 1,
            'asistencia' => date('Y-m-d H:i:s'),
            'register' => 'REGISTERED',
        ]);

        $upStudentAll = Student::where('uuid', $uuid)->first();

        return response()->json(
            [
                'type' => 'ok',
                'message' => 'Student Update Successfully',
                'data' => $upStudentAll,
            ],
            201
        );
    }

    public function updateDocument(Request $req, string $uuid)
    {
        $validations = [];
        $validations['allname'] = 'required';
        $validations['email'] = 'required|email';
        $validations['typedocument'] = 'required';
        $validations['document'] = 'required|integer|max_digits:15';

        $onlyDocumentValidate = Student::where('uuid', $uuid)->first();

        if ($onlyDocumentValidate == null) {
            return response()->json(
                [
                    'type' => 'error',
                    'message' => 'Student dont exist in database',
                ],
                404
            );
        }

        if ($req->document == $onlyDocumentValidate->document) {
            $rules['document'] = '';
            $rules['typedocument'] = '';
        } else {
            $rules['typedocument'] = 'required';
            $rules['document'] =
                'required|integer|unique:students|max_digits:15';
        }

        $customMessage = $this->allMessages();
        $validation = Validator::make(
            $req->all(),
            $validations,
            $customMessage
        );

        if ($validation->fails()) {
            return response()->json(
                ['type' => 'error', 'message' => $validation->errors()],
                422
            );
        }

        $upStudent = Student::where('uuid', $uuid)->update([
            'email' => $req->email,
            'allname' => $req->allname,
            'document' => $req->document,
            'typedocument' => $req->typedocument,
            'modify_document' => date('Y-m-d H:i:s'),
        ]);

        $upStudentAll = Student::where('uuid', $uuid)->first();

        return response()->json(
            [
                'type' => 'ok',
                'message' => 'Student Update Document Successfully',
                'data' => $upStudentAll,
            ],
            201
        );
    }

    public function firstSelected(Request $req, string $uuid)
    {
        $id = Student::select('id')
            ->where('uuid', $uuid)
            ->first();

        $validation = Validator::make(
            $req->all(),
            [
                'programs_a' => 'required|integer',
                'programs_b' => 'integer',
            ],
            []
        );

        //here 422 means unprocessable entity
        if ($validation->fails()) {
            return response()->json(
                ['type' => 'error', 'message' => $validation->errors()],
                422
            );
        }

        $selections = Selections::where('students_id', $id->id)->first();

        $pr_a = $this->validateProgram($req->programs_a);
        $pr_b = $this->validateProgram($req->programs_b);

        if ($selections == null) {
            Selections::create([
                'uuid' => (string) Str::uuid(),
                'students_id' => $id->id,
                'programs_a' => $pr_a,
                'programs_b' => $pr_b,
                'accept' => date('Y-m-d H:i:s.000000Z'),
                'active' => 1,
            ]);
        } else {
            Selections::where('students_id', $id->id)->update([
                'students_id' => $id->id,
                'programs_a' => $pr_a,
                'programs_b' => $pr_b,
                'accept' => date('Y-m-d H:i:s.000000Z'),
                'active' => 1,
            ]);
        }

        $selectionsFinal = Selections::where('students_id', $id->id)->first();
        return response()->json(
            [
                'type' => 'ok',
                'message' => 'Selection Created Successfully',
                'selection' => $selectionsFinal,
            ],
            201
        );
    }

    function validateProgram($program_id)
    {
        $program = Programs::where('id', $program_id)->first();

        if ($program === null) {
            return null;
        }

        return $program->id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req, string $uuid)
    {
        Student::where('uuid', $uuid)->delete();
        return response()->json(
            [
                'type' => 'ok',
                'message' => 'Student Delete Successfully',
            ],
            201
        );
    }
}
