import React, { useState, useMemo } from 'react';

import { Button } from 'react-bootstrap';
import PropertyFields from '../../../components/PropertyFields';

function SearchForm(props){
    const [transactionTypeId, setTransactionTypeId] = useState(3);

    const prefix = useMemo(() => {
        return transactionTypeId == 3?
        <div className="input-group-prepend input-group-append">
            <div className="input-group-text">$</div>
        </div>:
        <></>
    }, [transactionTypeId])

    const postfix = useMemo(() => {
        return transactionTypeId != 3?
        <div className="input-group-prepend input-group-append">
            <div className="input-group-text">{ __('common.ten_thousand') }</div>
        </div>:
        <></>
    }, [transactionTypeId])

    return (
    <form ref={props.formRef} className="form mx-2">
        <h5>{ __('common.basic') }</h5>

        <div className="form-row">
            <div className="form-group form-group-sm col-4">
                <label>{ __('common.status') }</label>
                <select className="form-control" name="customer_status_id">
                    <option value="">{ __('form.all') }</option>
                {
                    window._customer_statuses.map(item => (
                    <option value={item.id} key={item.id}>{item.name}</option>))
                }
                </select>
            </div>
            
            <div className="form-group form-group-sm col-4">
                <label>{__('people.name')}</label>
                <input type="text" className="form-control" name="name" />
            </div>
            <div className="form-group form-group-sm col-4">
                <label>{__('contact.title')}</label>
                <input type="text" className="form-control" name="contact" placeholder={`${__('form.min_length')} 4`}/>
            </div>
        </div>
        
        <h5>{ __('prefer.title') }</h5>

        <div className="form-row my-1">
            <div className="input-group input-group-sm col-auto col-lg-2 col-sm-4">
                <div className="input-group-prepend">
                    <div className="input-group-text">{ __('common.type') }</div>
                </div>
                <select 
                    className="form-control" 
                    name="transaction_type_id" value={transactionTypeId}
                    onChange={({target}) => setTransactionTypeId(target.value)}
                >
                {
                    window._transaction_types.map(type => (
                    <option value={type.id} key={`type_${type.id}`}>{type.name}</option>))
                }
                </select>
            </div>

            <div className="input-group input-group-sm col-auto col-lg-6 col-sm-8">
                <div className="input-group-prepend">
                    <div className="input-group-text">{ __('prefer.price') }</div>
                </div>
                {prefix}
                <input className="form-control" type="text" name="price_fm" />
                {postfix}
                <div className="input-group-prepend input-group-append">
                    <div className="input-group-text">{ __('form.to') }</div>
                </div>
                {prefix}
                <input className="form-control" type="text" name="price_to" />
                {postfix}
            </div>
        </div>

        <PropertyFields fields={['area', 'district', 'estate_type', 'estate', 'structure']}></PropertyFields>
        
        <div className="form-row d-flex justify-content-center my-2">
            <Button className="btn btn-sm btn-dark mx-2" onClick={() => props.submit()} type="button">
                <i className="fas fa-search mr-2"></i>
                {__('form.search')}
            </Button>
            <Button className="btn btn-sm btn-light mx-2">
                <i className="fas fa-undo mr-2"></i>
                {__('form.reset')}
            </Button>
        </div>
    </form>)
}

export default SearchForm;