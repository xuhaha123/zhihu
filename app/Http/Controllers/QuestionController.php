<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResquest;
use App\Question;
use App\Repositories\QuestionRepository;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
//        $this->middleware('auth')->except(['index','show']);原来有的
        $this->questionRepository =$questionRepository;
    }
    public function index()
    {
        $questions =$this->questionRepository->getQuestionsFeed();

        return view('questions.index',compact('questions'));
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
//        dd($request->get('topics'));把数组转换为id
//        $topics =$this->normalizeTopic($request->get('topics'));
        $topics =$this->questionRepository->normalizeTopic($request->get('topics'));

        $data =[
          'title'=>$request->get('title'),
          'body'=>$request->get('body'),
            'user_id'=>Auth::id()
        ];
//       $question =Question::create($data);
        $question =$this->questionRepository->create($data);
        $question->topics()->attach($topics);//多对多
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
//        $question =Question::find($id);
//        $question =Question::where('id',$id)->with('topics')->first();
        $question =$this->questionRepository->byIdWithTopics($id);

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
        $question =$this->questionRepository->byId($id);
        //用户是不是作者
        if(Auth::user()->owns($question))
        {
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//    }
    public function update(StoreResquest $request, $id)
    {
        $question =$this->questionRepository->byId($id);
        $topics =$this->questionRepository->normalizeTopic($request->get('topics'));
        $question->update([
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
        ]);
        $question->topics()->sync($topics);
        return redirect()->route('question.show',[$question->id]);



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
        $question =$this->questionRepository->byId($id);
        if(Auth::user()->owns($question))
        {
            $question->delete();
            return redirect('/');
        }
        abort(403,'Forbidden');
    }

}
