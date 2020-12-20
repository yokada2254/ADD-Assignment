import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';

import Property from '../property';
import People from '../people';
import Customer from '../customer';
import Details from './details';

function Transaction({transaction, disabled}){
    return (
    <>
    <input type="hidden"  name="package_id" value={transaction.package.id} />
    <input type="hidden"  name="transaction_type_id" value={transaction.transaction_type_id} />
    <div className="d-flex align-items-center justify-content-between">
        <h3 className="font-weight-bold">{ __('transaction.title') }</h3>
        <div className="btn-group">
        {
            disabled?
            <a className="btn btn-sm btn-primary" href={`/transaction/${transaction.id}/edit`}>
                <i className="fas fa-edit"></i>
            </a>:
            <>
            <button className="btn btn-sm btn-primary" type="submit">
                <i className="fas fa-save"></i>
            </button>
            <a className="btn btn-sm btn-danger" href={transaction?.id?`/transaction/${transaction.id}`:'/transaction'}>
                <i className="fas fa-times"></i>
            </a>
            </>
        }
        </div>
    </div>
    <div className="row">
        <div className="col-12 my-1">
            <Property disabled={true} items={transaction.package.properties}></Property>
        </div>
        
        <div className="col-lg-6 col-sm-12 my-1">
            <People disabled={true} title={__('transaction.seller')} items={transaction.package.owners}></People>
        </div>

        <div className="col-lg-6 col-sm-12 my-1">
            <Customer disabled={disabled} title={ __('transaction.buyer') } item={transaction.customer}></Customer>
        </div>

        <div className="col-12 my-1">
            <Details disabled={disabled} transaction={transaction} />
        </div>
    </div>
    </>)
}

Transaction.defaultProps = {
    transaction: {},
    disabled: false,
};

export default Transaction;

document.querySelectorAll('transaction').forEach(dom => {
    let props = Object.assign({}, dom.dataset);
    if(!!props.transaction) props.transaction = JSON.parse(props.transaction);
    if('disabled' in props) props.disabled = props.disabled == "true";

    console.log("props", props);
    ReactDOM.render(<Transaction {...props} />, dom);
});