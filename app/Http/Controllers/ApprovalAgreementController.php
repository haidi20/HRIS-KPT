<?php

namespace App\Http\Controllers;

use App\Models\ApprovalAgreement;
use App\Models\ApprovalLevel;
use App\Models\ApprovalLevelDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApprovalAgreementController extends Controller
{
    public function approve()
    {

        try {
            $request["approval_level_id"] =  request("approval_level_id");
            $request["user_id"] =  request("user_id");
            $request["model_id"] =  request("model_id");
            $request["name_model"] =  request("name_model");
            $request["status_approval"] =  request("status_approval");

            $storeApprovalAgreement = $this->storeApprovalAgreement($request);

            return response()->json([
                'success' => true,
                'data' => $storeApprovalAgreement,
                'message' => "Berhasil, data melakukan proses persetujuan",
            ], 201);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal, proses persetujuan',
            ], 500);
        }
    }

    public function history()
    {
        $data = ApprovalAgreement::byApprovalLevelId(request("approval_level_id"))
            ->byModel(request("model_id"), request("name_model"))
            ->where("status_approval", "!=", "not yet")
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => "Berhasil, dapat data history approval agreement",
        ], 201);
    }

    public function allHistory()
    {
        $data = ApprovalAgreement::byApprovalLevelId(request("approval_level_id"))
            ->byModel(request("model_id"), request("name_model"))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => "Berhasil, dapat data history approval agreement",
        ], 201);
    }

    public function mapApprovalAgreeent($model, $nameModel, $isByUser = true)
    {
        if (request("user_id") == null) {
            $userId = auth()->user()->id;
        } else {
            $userId = request("user_id");
        }

        $model->map(function ($query) use ($nameModel, $userId, $isByUser) {
            //CATATAN JANGAN DI HAPUS!!
            //sedang di persetujuan siapa
            //keterangan di status approval :
            //jika login pemohon :
            //  status approval = sedang di review oleh siapa
            //jika login yang meng'approve:
            //  status approval -> logic : tampil jika approval level berdasarkan user pembuat.
            //                              - jika di accept maka akan muncul label terima hijau
            //                              - jika di reject maka akan muncul label tolak merah
            //                              - jika review maka akan muncul label biru
            //                     keterangan : menunggu persetujuan / terima / tolak dengan warna biru jika belum di approve.
            //

            $approvalAgreementQuery = $approvalAgreement = ApprovalAgreement::byApprovalLevelId($query->approval_level_id)
                // ->byModel($query["id"], $nameModel)
                ->byModel($query["id"], $nameModel);

            $approvalAgreementUsers = $approvalAgreementQuery->pluck("user_id");

            $approvalAgreement = $approvalAgreementQuery
                ->where(function ($subQuery) use ($query, $userId, $isByUser) {

                    // berdasarkan user yang selain pembuat data.
                    if ($query->user_id != $userId && $isByUser) {
                        $subQuery->where("user_id", $userId);
                    }

                    $subQuery->where("status_approval", "<>", "not yet");
                })
                ->orderBy("level_approval", "desc")
                ->orderBy("created_at", "desc")
                ->first();



            $query->approval_user_id = $approvalAgreement ? $approvalAgreementUsers : null;
            $query->status_approval = $approvalAgreement ? $approvalAgreement->status_approval : null;
            $query->label_status_approval = $approvalAgreement ? $approvalAgreement->label_status_approval : null;
            $query->description_status_approval = $approvalAgreement ? $approvalAgreement->description_status_approval : null;
        });

        return $model;
    }


    public function storeApprovalAgreement($request)
    {
        $checkDataApprovalAgreement = ApprovalAgreement::byApprovalLevelId($request["approval_level_id"])
            ->byModel($request["model_id"], $request["name_model"])
            ->count();

        // langkah pertama kali atau jika data di approval agreement kosong.
        if ($checkDataApprovalAgreement == 0) {

            $approvalLevelDetail = ApprovalLevelDetail::byApprovalLevelId($request["approval_level_id"])
                ->orderBy("level", "asc")
                ->get();

            foreach ($approvalLevelDetail as $index => $item) {
                ApprovalAgreement::create([
                    "approval_level_id" => $item->approval_level_id,
                    "user_id" => $item->user_id,
                    "model_id" => $request["model_id"],
                    "name_model" => $request["name_model"],
                    "status_approval" => $index == 0 ? "review" : "not yet",
                    "level_approval" => $item->level,
                ]);
            }
        } else {
            if ($request['status_approval'] != "accept_onbehalf") {
                // $request['status_approval'] = "accept";

                // update status approval current level
                ApprovalAgreement::byApprovalLevelId($request["approval_level_id"])
                    ->byModel($request["model_id"], $request["name_model"])
                    ->where('user_id', $request['user_id'])
                    ->update(["status_approval" => $request['status_approval']]);
            }

            // $approvalLevel = ApprovalLevelDetail::byApprovalLevelId($request["approval_level_id"])
            //                                         ->where("user_id", $request["user_id"])
            //                                         ->first();

            // ApprovalAgreement::create([
            //     "approval_level_id" => $request["approval_level_id"],
            //     "user_id" => $request["user_id"],
            //     "name_model" => $request["name_model"],
            //     "model_id" => $request["model_id"],
            //     "status_approval" => $request["status_approval"],
            //     "level_approval" => $approvalLevel->level,
            // ]);

            $nextLevelApproval = ApprovalAgreement::byApprovalLevelId($request["approval_level_id"])
                ->byModel($request["model_id"], $request["name_model"])
                ->where("user_id", $request['user_id'])
                ->first()->level_approval + 1;

            $checkNextLevelApproval = ApprovalLevelDetail::byApprovalLevelId($request["approval_level_id"])
                ->where("level", $nextLevelApproval)
                ->first();

            // status approval di next level akan menjadi 'review'
            if ($request['status_approval'] == "accept") {

                // check apakah masih ada next level atau tidak
                if ($checkNextLevelApproval != null) {
                    ApprovalAgreement::byApprovalLevelId($request["approval_level_id"])
                        ->byModel($request["model_id"], $request["name_model"])
                        ->updateOrCreate([
                            "level_approval" => $nextLevelApproval,
                        ], [
                            "status_approval" => "review",
                        ]);
                }
            } else if ($request['status_approval'] == "reject") {
                // check apakah masih ada next level atau tidak
                if ($checkNextLevelApproval != null) {
                    // update status approval on all next level can be 'not yet'
                    ApprovalAgreement::byApprovalLevelId($request["approval_level_id"])
                        ->byModel($request["model_id"], $request["name_model"])
                        ->where("level_approval", ">=", $nextLevelApproval)
                        ->update(["status_approval" => "not yet"]);
                }
                // untuk atas nama approval
            } else if ($request['status_approval'] == "accept_onbehalf") {
                // check apakah masih ada next level atau tidak
                if ($checkNextLevelApproval != null) {
                    // update status approval on next level can be 'accept'
                    ApprovalAgreement::byApprovalLevelId($request["approval_level_id"])
                        ->byModel($request["model_id"], $request["name_model"])
                        ->where("level_approval", $nextLevelApproval)
                        ->update(["status_approval" => "accept", "user_behalf_id" => $request["user_behalf_id"]]);
                }
            }
        }

        return "Berhasil, update approval agreement";
    }
}
