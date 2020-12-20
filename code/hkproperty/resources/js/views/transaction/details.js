import React, { useState } from 'react';

function Details({transaction, disabled}){
    const [facilitatedBy, setFacilitatedBy] = useState(transaction?.facilitated_by);
    const [commission, setCommission] = useState(transaction?.commission);
    const [branch, setBranch] = useState(transaction?.branch_id);
    const [transactionDate, setTransactionDate] = useState(transaction?.transaction_date);
    const [amount, setAmount] = useState(transaction?.transaction_amount);

    const gridWidht = "col-lg-2 col-sm-4";

    return (
    <div className="card">
        <div className="card-header">
            <h5 className="font-weight-bold">{ __('transaction.details') }</h5>
        </div>
        <div className="card-body bg-dark text-white">
            <div className="row">
                <div className={gridWidht}>
                    <div className="form-group form-group-sm">
                        <label>{ __('prefer_offer.transaction_type') }</label>
                        <input 
                            className="form-control form-control-sm" 
                            type="text" value={transaction.transaction_type.name} 
                            disabled
                        />
                    </div>
                </div>
                <div className={gridWidht}>
                    <div className="form-group form-group-sm">
                        <label>{ __('transaction.amount') }</label>
                        <div className="input-group input-group-sm">
                        {
                            transaction.transaction_type_id == 3 &&
                            <div className="input-group-prepend">
                                <div className="input-group-text">$</div>
                            </div>
                        }
                            <input 
                                className="form-control text-right" 
                                name="transaction_amount" value={amount} 
                                onChange={({target}) => setAmount(target.value)} 
                                disabled={disabled}
                            />
                        {
                            transaction.transaction_type_id != 3 &&
                            <div className="input-group-append">
                                <div className="input-group-text">{ __('common.ten_thousand') }</div>
                            </div>
                        }
                        </div>
                    </div>
                </div>

                <div className={gridWidht}>
                    <div className="form-group form-group-sm">
                        <label>{ __('transaction.commission') }</label>
                        <div className="input-group input-group-sm">
                            <div className="input-group-prepend">
                                <div className="input-group-text">$</div>
                            </div>
                            <input 
                                className="form-control text-right" 
                                name="commission" value={commission} 
                                onChange={({target}) => setCommission(target.value)} 
                                disabled={disabled}
                            />
                        </div>
                    </div>
                </div>
                

                <div className={gridWidht}>
                    <div className="form-group form-group-sm">
                        <label>{ __('common.branch') }</label>
                        <select 
                            className="form-control form-control-sm" 
                            name="branch_id" value={branch} 
                            onChange={({target}) => setBranch(target.value)} 
                            disabled={disabled}
                        >
                        {
                            _branches.map(item => (
                            <option value={item.id} key={item.id}>{item.name}</option>))
                        }
                        </select>
                    </div>
                </div>
                
                <div className={gridWidht}>
                    <div className="form-group form-group-sm">
                        <label>{ __('transaction.faciliatedby') }</label>
                        <select 
                            className="form-control form-control-sm" 
                            name="facilitated_by" value={facilitatedBy} 
                            onChange={({target}) => setFacilitatedBy(target.value)} 
                            disabled={disabled}
                        >
                        {
                            _users.map(item => (
                            <option value={item.id} key={item.id}>{item.name}</option>))
                        }
                        </select>
                    </div>
                </div>
                
                <div className={gridWidht}>
                    <div className="form-group form-group-sm">
                        <label>{ __('transaction.date') }</label>
                        <input 
                            className="form-control form-control-sm" 
                            name="transaction_date" type="date" value={transactionDate} 
                            onChange={({target}) => setTransactionDate(target.value)} 
                            disabled={disabled}
                        />
                    </div>
                </div>
            </div>
        </div>

        <div className="card-footer">
        {
            !!transaction?.id &&
            <div className="row d-flex justify-content-between">
                <p className="mx-1 my-0">
                    <strong className="mr-1">{ __('common.created_by') }</strong>
                    { transaction.created_by.name }
                    <strong className="mx-1">@</strong>
                    { transaction.created_at }
                </p>
                <p className="mx-1 my-0">
                    <strong className="mr-1">{ __('common.updated_by') }</strong>
                    { transaction.updated_by.name }
                    <strong className="mx-1">@</strong>
                    { transaction.updated_at }
                </p>
            </div>
        }
        </div>

    </div>)
}

export default Details;