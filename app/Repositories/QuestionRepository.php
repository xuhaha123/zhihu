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

    private function normalizeTopic(array $topics)
    {
        return  collect($topics)->map(function($topic){
            if(is_numeric($topic))
            {
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
            $newTopic =Topic::create(['name'=>$topic,'questions_count'=>1]);
            return $newTopic->id;
        })->toArray();

    }

}