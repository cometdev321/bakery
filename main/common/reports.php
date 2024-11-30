<!-- reports for admin only -->
<?php if(isset($_SESSION['admin'])){?>
    
                            <li>
                                <a href="#menu-level-1" class="has-arrow"><i class="icon-book-open"></i> <span>All Branches Reports</span></a>
                                <ul>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Transaction Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/sale">Sale</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/purchase">Purchase</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/daybook">Day Book</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/transaction/alltransaction">All Transaction</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Party Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/allBranchReport/party/party_sales_report">PartyWise Sales Report</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/party/party_purchase_report">PartyWise Purchase Report</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/party/allParties">All Parties</a></li>
                                            <!-- <li><a href="<?php echo $base ?>/allBranchReport/party/partySummary">Sale Purchase By Party</a></li> -->
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Item/Stock Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/allBranchReport/stock/stockDetails">Stock Details</a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/stock/itemreport">Item Report </a></li>
                                            <li><a href="<?php echo $base ?>/allBranchReport/stock/stocksummary">Stock Summary</a></li>
                                            <!-- <li><a href="<?php echo $base ?>/allBranchReport/stock/lowStock">Low Stock Summary</a></li> -->
                                        </ul>
                                    </li>
                                    <!-- <li>
                                        <a href="#menu-level-2" class="has-arrow">Expense Report</a>
                                        <ul>
                                            <li><a href="">Expense Details</a></li>
                                        </ul>
                                    </li>
                                     -->
                                </ul>
                            </li>
                            <?php } ?>
                            <!-- reports for users -->
                            <?php
                                   if(!isset($_SESSION['admin'])){
                                ?>
                            <li>
                                <a href="#menu-level-1" class="has-arrow"><i class="icon-book-open"></i> <span>Reports</span></a>
                                <ul>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Transaction Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/reports/transaction/sale">Sale</a></li>
                                            <li><a href="<?php echo $base ?>/reports/transaction/purchase">Purchase</a></li>
                                            <li><a href="<?php echo $base ?>/reports/transaction/daybook">Day Book</a></li>
                                            <li><a href="<?php echo $base ?>/reports/transaction/alltransaction">All Transaction</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Party Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/reports/party/party_sales_report">PartyWise Sales Report</a></li>
                                            <li><a href="<?php echo $base ?>/reports/party/party_purchase_report">PartyWise Purchase Report</a></li>
                                            <li><a href="<?php echo $base ?>/reports/party/allParties">All Parties</a></li>
                                            <li><a href="<?php echo $base ?>/reports/party/partySummary">Sale Purchase By Party</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#menu-level-2" class="has-arrow">Item/Stock Report</a>
                                        <ul>
                                            <li><a href="<?php echo $base ?>/reports/stock/stockDetails">Stock Details</a></li>
                                            <li><a href="<?php echo $base ?>/reports/stock/itemreport">Item Report </a></li>
                                            <li><a href="<?php echo $base ?>/reports/stock/stocksummary">Stock Summary</a></li>
                                            <!-- <li><a href="<?php echo $base ?>/reports/stock/lowStock">Low Stock Summary</a></li> -->
                                        </ul>
                                    </li>
                                    <!-- <li>
                                        <a href="#menu-level-2" class="has-arrow">Expense Report</a>
                                        <ul>
                                            <li><a href="">Expense Details</a></li>
                                        </ul>
                                    </li> -->
                                    
                                </ul>
                            </li>
                            <?php } ?>