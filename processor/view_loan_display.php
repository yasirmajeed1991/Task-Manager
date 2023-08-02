<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$type_arr = array('',"Admin","Project Manager","Employee");
	$qry = $conn->query("SELECT * From loan_file where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
    <div class="card card-widget widget-user shadow">
        <div class="widget-user-header bg-dark">
            <h3 class="widget-user-username"><?php echo ucwords($name) ?></h3>
            <h5 class="widget-user-desc"><?php echo $loan_number ?></h5>
			
        </div>

        <div class="card-footer">
            <div class="col-lg-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                      

                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Branch</label>
                                        <select name="branch" id="branch" class="custom-select custom-select-sm" disabled>

                                            <?php 
              	$managers = $conn->query("SELECT * FROM branch ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                            <option value="<?php echo $row['id'] ?>"
                                                <?php echo isset($branch) && $branch == $row['id'] ? "selected" : '' ?>>
                                                <?php echo ucwords($row['branch']) ?></option>
                                            <?php endwhile; ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Processing Manager</label>
                                        <select name="processing_manager" id="processing_manager"
                                            class="custom-select custom-select-sm" disabled>

                                            <?php 
              	$managers = $conn->query("SELECT * FROM users where type=2 ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                            <option value="<?php echo $row['id'] ?>"
                                                <?php echo isset($processing_manager) && $processing_manager == $row['id'] ? "selected" : '' ?>>
                                                <?php echo ucwords($row['firstname'] . $row['lastname'] ) ?></option>
                                            <?php endwhile; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Processor</label>
                                        <select name="processor" id="processor" class="custom-select custom-select-sm" disabled>

                                            <?php 
              	$managers = $conn->query("SELECT * FROM users where type=3 ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                            <option value="<?php echo $row['id'] ?>"
                                                <?php echo isset($processor) && $processor == $row['id'] ? "selected" : '' ?>>
                                                <?php echo ucwords($row['firstname'] . $row['lastname'] ) ?></option>
                                            <?php endwhile; ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Loan Coordinating Manager</label>
                                        <select name="loan_coordinating_manager" id="loan_coordinating_manager"
                                            class="custom-select custom-select-sm" disabled>

                                            <?php 
              	$managers = $conn->query("SELECT * FROM users where type=4 ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                            <option value="<?php echo $row['id'] ?>"
                                                <?php echo isset($loan_coordinating_manager) && $loan_coordinating_manager == $row['id'] ? "selected" : '' ?>>
                                                <?php echo ucwords($row['firstname'] . $row['lastname'] ) ?></option>
                                            <?php endwhile; ?>


                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Assigned Loan Coordinator</label>
                                        <select name="assigned_loan_coordinating_manager"
                                            id="assigned_loan_coordinating_manager"
                                            class="custom-select custom-select-sm" disabled>

                                            <?php 
              	$managers = $conn->query("SELECT * FROM users where type=5 ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                            <option value="<?php echo $row['id'] ?>"
                                                <?php echo isset($assigned_loan_coordinating_manager) && $assigned_loan_coordinating_manager == $row['id'] ? "selected" : '' ?>>
                                                <?php echo ucwords($row['firstname'] . $row['lastname'] ) ?></option>
                                            <?php endwhile; ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Name</label>
                                        <input type="text" class="form-control form-control-sm" name="name"
                                            value="<?php echo isset($name) ? $name : '' ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Milestone</label>
                                        <select name="milestone" id="milestone" class="custom-select custom-select-sm" disabled>
                                            <option value="1"
                                                <?php echo isset($milestone) && $milestone == 1 ? 'selected' : '' ?>>
                                                Initial Review</option>
                                            <option value="2"
                                                <?php echo isset($milestone) && $milestone == 2 ? 'selected' : '' ?>>
                                                Submittal</option>
                                            <option value="3"
                                                <?php echo isset($milestone) && $milestone == 3 ? 'selected' : '' ?>>
                                                Pre-Processing</option>
                                            <option value="4"
                                                <?php echo isset($milestone) && $milestone == 4 ? 'selected' : '' ?>>
                                                Processing</option>
                                            <option value="5"
                                                <?php echo isset($milestone) && $milestone == 5 ? 'selected' : '' ?>>
                                                Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Lock Expiration Date</label>
                                        <input type="date" class="form-control form-control-sm" autocomplete="off"
                                            name="lock_expiration_date"
                                            value="<?php echo isset($lock_expiration_date) ? date("Y-m-d",strtotime($lock_expiration_date)) : '' ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Scrub Received</label>
                                        <input type="datetime-local" class="form-control form-control-sm"
                                            autocomplete="off" name="scrub_received"
                                            value="<?php echo isset($scrub_received) ? $scrub_received : '' ?>" disabled>

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Scrub Started</label>
                                        <input type="datetime-local" class="form-control form-control-sm"
                                            autocomplete="off" name="scrub_started"
                                            value="<?php echo isset($scrub_started) ? $scrub_started : '' ?>" disabled> 

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Scrub Completed</label>
                                        <input type="datetime-local" class="form-control form-control-sm"
                                            autocomplete="off" name="scrub_completed"
                                            value="<?php echo isset($scrub_completed) ? $scrub_completed : '' ?>" disabled>

                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="" class="control-label">EOI/HOI/MASTER POLICY/FLOOD</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="eoi_hoi_master_policy_flood[]" disabled
                                                    class="form-control form-control-sm" autocomplete="off"
                                                    value="<?php $eoi_hoi_master_policy_flood=json_decode($eoi_hoi_master_policy_flood);echo isset($eoi_hoi_master_policy_flood[0]) ? $eoi_hoi_master_policy_flood[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="eoi_hoi_master_policy_flood[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($eoi_hoi_master_policy_flood[1]) ? $eoi_hoi_master_policy_flood[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="eoi_hoi_master_policy_flood[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($eoi_hoi_master_policy_flood[2]) ? $eoi_hoi_master_policy_flood[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Mortgage Payoff</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="mortgage_payoff[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $mortgage_payoff=json_decode($mortgage_payoff); echo isset($mortgage_payoff[0]) ? $mortgage_payoff[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="mortgage_payoff[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($mortgage_payoff[1]) ? $mortgage_payoff[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="mortgage_payoff[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($mortgage_payoff[2]) ? $mortgage_payoff[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Collection Payoff</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="collection_payoff[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $collection_payoff=json_decode($collection_payoff);  echo isset($collection_payoff[0]) ? $collection_payoff[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="collection_payoff[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($collection_payoff[1]) ? $collection_payoff[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="collection_payoff[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($collection_payoff[2]) ? $collection_payoff[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Credit Supplement</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="credit_supplement[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $credit_supplement=json_decode($credit_supplement); echo isset($credit_supplement[0]) ? $credit_supplement[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="credit_supplement[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($credit_supplement[1]) ? $credit_supplement[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="credit_supplement[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($credit_supplement[2]) ? $credit_supplement[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">VVOE/WVOE</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="vvoe_wvoe[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $vvoe_wvoe=json_decode($vvoe_wvoe); echo isset($vvoe_wvoe[0]) ? $vvoe_wvoe[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="vvoe_wvoe[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($vvoe_wvoe[1]) ? $vvoe_wvoe[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="vvoe_wvoe[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($vvoe_wvoe[2]) ? $vvoe_wvoe[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Tax Transcript</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="tax_transcript[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $tax_transcript=json_decode($tax_transcript); echo isset($tax_transcript[0]) ? $tax_transcript[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="tax_transcript[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($tax_transcript[1]) ? $tax_transcript[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="tax_transcript[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($tax_transcript[2]) ? $tax_transcript[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Pest Inspection</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="pest_inspection[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $pest_inspection=json_decode($pest_inspection); echo isset($pest_inspection[0]) ? $pest_inspection[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="pest_inspection[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($pest_inspection[1]) ? $pest_inspection[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="pest_inspection[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($pest_inspection[2]) ? $pest_inspection[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">24 Payment-VOM</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="payment_vom[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $payment_vom=json_decode($payment_vom); echo isset($payment_vom[0]) ? $payment_vom[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="payment_vom[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($payment_vom[1]) ? $payment_vom[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="payment_vom[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($payment_vom[2]) ? $payment_vom[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Title Docs</label>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">1st</div>
                                                </div>
                                                <input type="text" name="title_docs[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php $title_docs=json_decode($title_docs); echo isset($title_docs[0]) ? $title_docs[0] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">2nd</div>
                                                </div>
                                                <input type="text" name="title_docs[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($title_docs[1]) ? $title_docs[1] : '' ?>">
                                            </div>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text form-control-sm">3rd</div>
                                                </div>
                                                <input type="text" name="title_docs[]"
                                                    class="form-control form-control-sm" autocomplete="off" disabled
                                                    value="<?php echo isset($title_docs[2]) ? $title_docs[2] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">USPS</label>
                                        <select name="usps" id="usps" class="custom-select custom-select-sm" disabled>

                                            <option value="1"
                                                <?php echo isset($usps) && $usps == 1 ? 'selected' : '' ?>>
                                                N/A</option>
                                            <option value="2"
                                                <?php echo isset($usps) && $usps == 2 ? 'selected' : '' ?>>
                                                In File</option>
                                            <option value="3" <?php echo isset($usps) && $usps == 3? 'selected' : '' ?>>
                                                Pulled</option>
                                            <option value="4" <?php echo isset($usps) && $usps == 4? 'selected' : '' ?>>
                                                Not Yet
                                                Pulled</option>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Demotech</label>
                                        <select name="demotech" id="demotech" class="custom-select custom-select-sm" disabled>
                                            <option value="1"
                                                <?php echo isset($demotech) && $demotech == 1 ? 'selected' : '' ?>>
                                                N/A</option>
                                            <option value="2"
                                                <?php echo isset($demotech) && $demotech == 2 ? 'selected' : '' ?>>
                                                In File</option>
                                            <option value="3"
                                                <?php echo isset($demotech) && $demotech == 3? 'selected' : '' ?>>
                                                Pulled</option>
                                            <option value="4"
                                                <?php echo isset($demotech) && $demotech == 4? 'selected' : '' ?>>
                                                Not Yet
                                                Pulled</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Proof of Title Company</label>
                                        <select name="proof_of_title_company" id="proof_of_title_company" disabled
                                            class="custom-select custom-select-sm">
                                            <option value="1"
                                                <?php echo isset($proof_of_title_company) && $proof_of_title_company == 1 ? 'selected' : '' ?>>
                                                N/A</option>
                                            <option value="2"
                                                <?php echo isset($proof_of_title_company) && $proof_of_title_company == 2 ? 'selected' : '' ?>>
                                                In File</option>
                                            <option value="3"
                                                <?php echo isset($proof_of_title_company) && $proof_of_title_company == 3? 'selected' : '' ?>>
                                                Pulled</option>
                                            <option value="4"
                                                <?php echo isset($proof_of_title_company) && $proof_of_title_company == 4? 'selected' : '' ?>>
                                                Not Yet
                                                Pulled</option>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">2036 Screen Updated?</label>
                                        <select name="screen_updated" id="screen_updated" disabled
                                            class="custom-select custom-select-sm">
                                            <option value="1"
                                                <?php echo isset($screen_updated) && $screen_updated == 1 ? 'selected' : '' ?>>
                                                No</option>
                                            <option value="2"
                                                <?php echo isset($screen_updated) && $screen_updated == 2 ? 'selected' : '' ?>>
                                                Yes</option>




                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">Scrubbed</label>
                                        <select name="scrubbed" id="scrubbed" class="custom-select custom-select-sm" disabled>
                                            <option value="1"
                                                <?php echo isset($scrubbed) && $scrubbed == 1 ? 'selected' : '' ?>>
                                                No</option>
                                            <option value="2"
                                                <?php echo isset($scrubbed) && $scrubbed == 2 ? 'selected' : '' ?>>
                                                Yes</option>
                                            <option value="3"
                                                <?php echo isset($scrubbed) && $scrubbed == 3 ? 'selected' : '' ?>>
                                                In Progress</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="" class="control-label">Remarks</label>
                                        <textarea name="remarks" id="remarks" cols="30" rows="10" disabled
                                            class="summernote form-control">
						<?php echo isset($remarks) ? $remarks : '' ?>
					</textarea>
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer display p-0 m-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
#uni_modal .modal-footer {
    display: none
}

#uni_modal .modal-footer.display {
    display: flex
}
</style>