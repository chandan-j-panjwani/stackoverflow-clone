<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    /**
     * MUTATORS: These are special functions which have setXXXAttribute($value)
     */
    public function setTitleAttribute($title){
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }

    /**
     * ACCESSORS: These are special functions which have setXXXAttribute($value)
     */
    public function getUrlAttribute() {
        return "/questions/{$this->slug}";
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getAnswersStyleAttribute() {
        if($this->answers_count > 0) {
            if($this->best_answer_id) {
                return "has-best-answer";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoriteAttribute()
    {
       return $this->favorites()->where(['user_id'=>auth()->id()])->count()>0;
    }

    // public function getFullNameAttribute() {
    //     return $this->first_name . " " . $this->last_name;
    // }

    /**
     * RELATIONSHIP METHODS
     */
    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function answers() {
        return $this->hasMany(Answer::class);
    }
    public function favorites() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public function votes() {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
    /**
     * HELPER FUNCTIONS
     */
    public function markBestAnswer(Answer $answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function vote(int $vote) {
        $this->votes()->attach(auth()->id(), ['vote' => $vote]);
        if($vote < 0) {
            $this->decrement('votes_count');
        }
        else {
            $this->increment('votes_count');
        }
    }

    public function updateVote(int $vote) {
        // User may have already up-voted this question and now down votes (votes_count = 10) and now user down votes (vote_count = 9) votes_count=8
        $this->votes()->updateExistingPivot(auth()->id(), ['vote' => $vote]);
        if($vote < 0) {
            $this->decrement('votes_count');
            $this->decrement('votes_count');
        }else {
            $this->increment('votes_count');
            $this->increment('votes_count');
        }
    }
}
