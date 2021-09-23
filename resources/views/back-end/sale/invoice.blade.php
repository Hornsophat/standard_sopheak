<div class="row d-none" id="print-element">
            <div class="col-md-12">
              <div class="tile">
                <section class="invoice">
                  <div class="row mb-4">
                    <div class="col-6">
                      <h2 class="page-header"><i class="fa fa-globe"></i><!-- Title --></h2>
                    </div>
                    <div class="col-6">
                      <h5 class="text-right">Invoice</h5>
                    </div>
                  </div>
                  <div class="row invoice-info">
                    <table style="border: 0px solid white !important;" border="0" cellspacing="0" cellpadding="5" width="100%" bgcolor="white">
                        <tr>
                            <td style="border: 0px solid white !important;">
                                <b>Invoice #007612</b><br><b>Payment Due:</b> {{Date('d/M/Y')}}<br><b>Account:<a id="customer_name"></a></b>
                            </td>
                        </tr>
                    </table>

                  <div class="row">
                    <div class="col-12 table-responsive table-print">
                      <table id="table-print" class="table table-striped" border="1" cellpadding="5" cellspacing="0" width="100%">
                        
                      </table>
                    </div>
                  </div>
                </section>
              </div>
            </div>
        </div>