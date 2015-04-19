<!-- Main Row 
=============================================== -->
<div class="container-fluid">
    <div class="row-fluid">
        <div class="well">
            <h2 class="text-info"><a href="<? echo URL; ?>loan">Piutang</a>&nbsp;&nbsp;<small>Riwayat Hutang Pelanggan</small></h2>
        </div>

        <div class="well">
            <div class="printArea">
                <legend><small>Riwayat Hutang :</small> <? echo $this->costumerDetails['name']; ?></legend>
                <p>
                    Kode : <? echo $this->costumerDetails['code']; ?></br>
                    Alamat : <? echo $this->costumerDetails['address']; ?></br>
                    Telepon : <? echo $this->costumerDetails['phone']; ?></br>
                </p>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width='15%' style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Nomor Tagihan</th>
                            <th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Deadline</th>
                            <th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">Status</th>
                            <th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;"><span class="pull-right">Total Hutang (Rp)</span></th>
                            <th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;"><span class="pull-right">Down Payment (Rp)</span></th>
                            <th style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;"><span class="pull-right">Sisa Piutang (Rp)</span></th>
                        </tr>
                    </thead>


                    <tbody id="tblLoan">
                    <? $sumTotal = 0; $sumDP = 0; $sumBalance = 0;
                        foreach ($this->listLoan as $key => $value) { 
                            $sumTotal += $value['total']; $sumDP += $value['dp']; $sumBalance += $value['balance']; ?>
                        <tr>
                            <td><a href="#" onClick="loadHistoryPayment(<? echo $value['id']; ?>)"><? echo $value['code']; ?></a></td>
                            <td>
                                <? if(($value['settled'] == 0) && (date('Y-m-d') >= date('Y-m-d', strtotime($value['deadline'])))) : ?> 
                                    <span class='text-error'><? echo date('d-m-Y', strtotime($value['deadline'])); ?></span>
                                <? else: ?>
                                    <span class="text-info"><? echo date('d-m-Y', strtotime($value['deadline'])); ?></span>
                                <? endif; ?>
                            </td>
                            <td><? echo $value['settled'] == 0 ? "Belum Lunas" : "Lunas"; ?></td>
                            <td><span class="pull-right"><? echo $this->pecahNoRp($value['total']); ?></span></td>
                            <td><span class="pull-right"><? echo $this->pecahNoRP($value['dp']); ?></span></td>
                            <td><span class="pull-right"><? echo $this->pecahNoRP($value['balance']); ?></span></td>
                        </tr>
                    <? } ?>
                        <tr>
                            <td colspan="3" style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;"><span class="pull-right">Total  </span></td>
                            <td style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;"><span class="pull-right"><? echo $this->pecahNoRP($sumTotal) ?></span></td>
                            <td style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;"><span class="pull-right"><? echo $this->pecahNoRP($sumDP) ?></span></td>
                            <td style="border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;"><span class="pull-right"><? echo $this->pecahNoRP($sumBalance) ?></span></td>
                        </tr>
                    </tbody>
                </table>

            </div><!-- End of printArea -->

            <div class="pull-right">
                <button class="btn btn-inverse" onClick="printArea()"><i class="icon-print icon-white"></i> Cetak</button>
            </div>
            <br>

        </div>

    </div>
</div>