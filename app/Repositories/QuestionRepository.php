<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 15:58
 */

namespace App\Repositories;

use App\Question;
use App\Topic;

class QuestionRepository
{
    public function byIdWithTopics($id)
    {
        return Question::where('id',$id)->with('topics')->first();
    }
    public function create(array $attibute)
    {
        return Question::create($attibute);

    }

    public function normalizeTopic(array $topics)
    {
//        return  collect($topics)->map(function($topic){
//            if(is_numeric($topic))
//            {
//                dd( Topic::find($topic));null
//                Topic::find($topic)->increment('questions_count');
//                return (int) $topic;
//            }
//            $newTopic =Topic::create(['name'=>$topic,'questions_count'=>1]);
//            return $newTopic->id;
//        })->toArray();
//        防止数字标签
//防止重复创建标签（输入已有标签，不选提示框里的直接回车，会建立重复标签）
        $ids = Topic::pluck('id');

        $ids = collect($topics)->map(function ($topic) use ($ids) {
            if (is_numeric($topic) && $ids->contains($topic)) {
                return (int) $topic;
            }

            return Topic::firstOrCreate(['name' => $topic])->id;
        })->toArray();
        Topic::whereIn('id', $ids)->increment('questions_count');
        return $ids;
    }
    public function byId($id)
    {
        return Question::find($id);

    }
    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

}