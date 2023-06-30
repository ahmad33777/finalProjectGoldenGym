<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\TrainerComplaint;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    //

    public function index()
    {
        $complaints = Complaint::with('subscriber')->where('status', false)->get();
        return view('complaints.index')->with(
            [
                'complaints' => $complaints,
             ]
        );
    }

    
    public function archives()
    {

        $complaints = Complaint::with('subscriber')->paginate(30);

        return view('complaints.archives')->with('complaints', $complaints);
    }

    // Read the complaint
    public function readComplaint($complaintID)
    {
        $complaint = Complaint::find($complaintID);
        $complaint->status = true;
        $status = $complaint->save();
        session()->flash('status', $status);
        return redirect()->route('complaints.index');
    }

    public function trainerComplaints(){
        $trainer_complaints = TrainerComplaint::where('status', false)->get();
        return view('complaints.trainerscomplaints')->with(
            [
                 'trainer_complaints' => $trainer_complaints
            ]
        );
    }


    public function readTrainerComplaint($complaintID)
    {
        $complaint = TrainerComplaint::find($complaintID);
        $complaint->status = true;
        $status = $complaint->save();
        session()->flash('status', $status);
        return redirect()->route('complaints.index');
    }

}