<?php

namespace App\Models;

// use Illuminate\Contracts\Database\Eloquent\Builder as QuaryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title)
    {
        return $query->where("title","LIKE","%".$title."%");
    }

    public function scopeReviewCounts(Builder $query,    $from = null,   $to = null){
        return $query->withCount(['reviews' => fn(Builder $q) => $this->timeRange($q, $from, $to)]);
    }

    public function scopeAvgRating(Builder $query,    $from = null,   $to = null){
        return $query->withAvg(['reviews' => fn(Builder $q) => $this->timeRange($q, $from, $to)], 'rating');
        }

    public function scopePopular(Builder $query,    $from = null,   $to = null){
        return $query->reviewCounts()
        ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRating(Builder $query,  $from = null,   $to = null){
        return $query->avgRating()
        ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, $minReview){
        return $query->having('reviews_count', '>=', $minReview);
}

public function scopePLM(Builder $query){
    return $query->popular(now()->subMonth(), now())
    ->highestRating(now()->subMonth(), now())
    ->minReviews(1);
}

public function scopePL6M(Builder $query){
    return $query->popular(now()->subMonths(6), now())
    ->highestRating(now()->subMonths(6), now())
    ->minReviews(1);
    
}
public function scopeHRLM(Builder $query){
    return $query->highestRating(now()->subMonth(), now())
    ->popular(now()->subMonth(), now())
    ->minReviews(1);
}
public function scopeHRL6M(Builder $query){
    return $query->highestRating(now()->subMonths(6), now())
    ->popular(now()->subMonths(6), now())
    ->minReviews(1);
}
private function timeRange(Builder $query,  $from = null,   $to = null){
    if($from && !$to)
    $query->where('created_at', '>=', $from);
    elseif(!$from && $to)
    $query->where('created_at','<=', $to);
    elseif($from && $to)
    $query->whereBetween('created_at', [$from,$to]);
}

protected static function booted()
{
    static::updated(
        fn (Book $book) => cache()->forget('book:' . $book->id));
    static::deleted(
        
        fn (Book $book) => cache()->forget('book:' . $book->id));
}
}