<?php

namespace App\Http\Controllers;

use App\Models\TimePeriod as ModelsTimePeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TimePeriod extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $time_periods = ModelsTimePeriod::orderBy('id')->paginate(10);
        return view('time-periods.index', compact('time_periods'));
    }

    public function create()
    {
        return view('time-periods.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'period' => ['required', 'unique:time_periods,period'],
        ]);

        if (ModelsTimePeriod::create($validated))
            return back()->with('success', 'بازه زمانی با موفقیت ایجاد شد!');
    }


    public function edit(ModelsTimePeriod $time_period)
    {
        return view('time-periods.edit', compact('time_period'));
    }


    public function update(ModelsTimePeriod $time_period, Request $request)
    {
        $validated = $request->validate([
            'period' => ['required', Rule::unique('time_periods', 'period')->ignore($time_period->id)],
        ]);

        if ($time_period->update($validated))
            return redirect()->route('time-periods.index')->with('success', 'ویرایش با موفقیت انجام شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsTimePeriod $time_period)
    {
        if ($time_period->delete())
            return redirect()->back()->with('success', 'حذف با موفقیت انجام شد!');
    }
}
