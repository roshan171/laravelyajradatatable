<?php 
namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreStudentRequest;
use DataTables;

class StudentController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth');
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $students = Student::latest()->paginate(10);
    //     return view('student.index', compact('students'));
    // }   public function index()
    public function index(){

        if(request()->ajax()) {
            return datatables()->of(Company::select('*'))->addColumn('action', 'student.action')->rawColumns(['action'])->addIndexColumn()->make(true);
        }
        return view('student.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'city' => 'required|string|max:255',
        ]);

        $student = new Student;
        $student->name = $request->name;
        $student->email = $request->email;
        $student->city = $request->city;
        $student->save();

        return redirect(route('student.index'))->with('success', 'Data submitted successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'city' => 'required|string|max:255',
        ]);

        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->city = $request->city;
        $student->save();

        return redirect(route('student.index'))->with('success', 'Data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect(route('student.index'))->with('success', 'Data deleted successfully!');
    }

    public function get_student_data()
    {
        return Excel::download(new StudentExport, 'students.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('file');
        Excel::import(new StudentImport, $file);

        return redirect()->back()->with('success', 'Students imported successfully.');
    }
}