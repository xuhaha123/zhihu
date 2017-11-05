<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResquest;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 222;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResquest $request)
    {
        //发表问题验证字段
//        $rules =[
//            'title'=>'required|min:6|max:196',
//            'body'=>'required|min:26',
//        ];
//        $message=[
//            'title.required'=>'标题不能为空',
//            'title.min'=>'标题不能少于6位',
//            'body.required'=>'内容不能为空',
//            'body.min'=>'内容不能少于26 '
//        ];
//        $this->validate($request,$rules,$message);
        //通过依赖注入
        $data =[
          'title'=>$request->get('title'),
          'body'=>$request->get('body'),
            'user_id'=>Auth::id()
        ];
       $question = Question::create($data);
        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $question =Question::find($id);
//        return $question;
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
