<?php

namespace Database\Seeders;
use DB;

use App\Models\Document;
use App\Models\TrackingRecord;
use App\Models\User;

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::with('office')->where('role_id', 2)->get();
        foreach($users as $user) {
            if($user->id%2 == 0) {
                for($i = 0; $i < 400; $i++) {
                    DB::beginTransaction();
                    try {
                        $source = rand(0, 1);
                        $document = new Document;
                        $document->title = strtoupper($faker->realText(20));
                        $document->is_external = $source == 0 ? false : true;
                        $document->document_type_id = rand(1,7);
                        $document->originating_office = $source == 0 ? rand(1, 3) : $faker->title;
                        $document->current_office_id = $user->office->id;
                        $document->sender_name = $source == 0 ? rand(3, 12) : $faker->title;
                        $document->page_count = rand(1,50);
                        $document->date_filed = $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null);
                        $document->is_terminal = $source == 0 ? false : true;
                        $document->remarks = $faker->realText(100);
                        $document->attachment_page_count = rand(1,50);
                        $document->tracking_code = $this->buildTrackingNumber(
                            $source,
                            $user->office->office_code,
                            $document->attachment_page_count,
                            $document->date_filed
                        );
                        $document->save();

                        $datetime = Carbon::now();
                        $tracking_record = new TrackingRecord;
                        $tracking_record->document_id = $document->id;
                        $tracking_record->actions = 10;
                        $tracking_record->status = 20;
                        $tracking_record->touched_by = $user->id;
                        $tracking_record->last_touched = $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null);
                        $tracking_record->remarks = 'generated by document creation';
                        $tracking_record->save();

                    } catch(ValidationException $error) {
                        DB::rollback();
                        throw $error;
                    } catch(\Exception $error) {
                        DB::rollback();
                        throw $error;
                    }
                    DB::commit();
                }
            }
            for($i = 0; $i < 100; $i++) {
                DB::beginTransaction();
                    try {
                        $source = rand(0, 1);
                        $document = new Document;
                        $document->title = strtoupper($faker->realText(20));
                        $document->is_external = $source == 0 ? false : true;
                        $document->document_type_id = rand(1, 7);
                        $document->originating_office = $source == 0 ? rand(1, 3) : $faker->title;
                        $document->current_office_id = $user->office->id;
                        $document->sender_name = $source == 0 ? rand(3, 12) : $faker->title;
                        $document->page_count = rand(1,50);
                        $document->date_filed = $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null);
                        $document->is_terminal = $source == 0 ? false : true;
                        $document->remarks = $faker->realText(100);
                        $document->attachment_page_count = rand(1, 50);
                        $document->tracking_code = $this->buildTrackingNumber(
                            $source,
                            $user->office->office_code,
                            $document->attachment_page_count,
                            $document->date_filed
                        );
                        $document->save();

                        $datetime = Carbon::now();
                        $tracking_record = new TrackingRecord;
                        $tracking_record->document_id = $document->id;
                        $tracking_record->actions = 10;
                        $tracking_record->status = 20;
                        $tracking_record->touched_by = $user->id;
                        $tracking_record->last_touched = $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null);
                        $tracking_record->remarks = 'generated by document creation';
                        $tracking_record->save();

                    } catch(ValidationException $error) {
                        DB::rollback();
                        throw $error;
                    } catch(\Exception $error) {
                        DB::rollback();
                        throw $error;
                    }
                    DB::commit();
            }
        }
    }

    private function buildTrackingNumber($source, $office_code, $attachment, $date) {
        $origin = 'I';
        if ($source) {
            $origin = 'E';
        }
        $parsed_date = Carbon::parse($date);
        $tracking = $origin.'-'.$office_code.'-'.$parsed_date->year.$parsed_date->month.$parsed_date->day.'-'.substr(str_shuffle("0123456789"), 0, 5).'-'.$attachment;
        return $tracking;
    }
}