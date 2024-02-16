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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request()->ajax()) {
            return datatables()->of(Student::select('*'))->addColumn('action', 'student.action')->rawColumns(['action'])->addIndexColumn()->make(true);
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
            'name' => 'required|alpha|max:255',
            'email' => 'required|email|unique:companies,email',
            'city' => 'required|string|max:255'
        ]);

        $Student = new Student;

        $Student->name = $request->name;
        $Student->email = $request->email;
        $Student->city = $request->city;


        $Student->save();

     
        return redirect()->route('student.index')->with('success','Company has been created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $Student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $Student)
    {
        return view('student.show',compact('student'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $Student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('student.edit',compact('student'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $Student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:companies,email',
            'city' => 'required|string|max:255'
        ]);
        
        $Student = Student::find($id);

        $Student->name = $request->name;
        $Student->email = $request->email;
        $Student->city = $request->city;

        $Student->save();
    
        return redirect()->route('student.index')->with('success','Company Has Been updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $Student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    
        $com = Student::where('id',$request->id)->delete();
     
        return Response()->json($com);
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