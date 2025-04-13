<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ResumeAIService;

class ResumeBuilderController extends Controller
{
    protected $resumeAIService;

    public function __construct(ResumeAIService $resumeAIService)
    {
        $this->resumeAIService = $resumeAIService;
    }

    public function index(){
        return view('tools.resume-builder');
    }

    public function resumeBuilder(Request $request)
    {
        $jobRole = $request->input('job_role');
        $resume = $this->resumeAIService->generateResume($jobRole);
        
        return response()->json(['resume' => $resume]);
    }
}
