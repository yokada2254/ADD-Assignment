import React, { useState, useReducer } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

import { Modal, Button, Form} from 'react-bootstrap';

import { SelectedTypes, selectedReducer } from '../search/selected';
import SearchCustomer from '../search/customer/';
import { ContactButton} from '../people/contact';

function Customer({disabled, item, title}){
    const [showSearch, setShowSearch] = useState(false);
    const [customer, setCustomer] = useState(item);

    const onClose = item => {
        setShowSearch(false);
        if(!!item){
            setCustomer(item);
        }
    }

    return (
    <>
    <div className="card">
        <input type="hidden" name="customer_id" value={customer?.id} />
        <div className="card-header d-flex justify-content-between align-items-center">
            <h5 className="font-weight-bold">{title}</h5>
        {
            disabled?
            <div></div>:
            <Button size="sm" variant="dark" onClick={() => setShowSearch(true)}>
                <i className="fas fa-check-square mr-2"></i>
                { window.__('form.select') }
            </Button>
        }
        </div>
        <div className="card-body p-0">
        {
            customer?.people?.length > 0 &&
            <table className="table table-dark table-stiped m-0">
                <colgroup>
                    <col width="*" />
                    <col width="*" />
                    <col width="90" />
                </colgroup>
                <thead>
                <tr>
                    <td>{window.__('people.name')}</td>
                    <td>{window.__('people.gender')}</td>
                    <td>&nbsp;</td>
                </tr>
                </thead>
                <tbody>
            {
                customer?.people.map(item => (
                <tr key={`item_${item.id}`}>
                    <td>{item.name}<input type="hidden" name="people_id[]" value={item.id} /></td>
                    <td>{item.gender??'-'}</td>
                    <td>
                        <ContactButton peopleId={item.id} />
                    </td>
                </tr>))
            }
                </tbody>
            </table>
        }
        </div>
        <div className="card-footer"></div>
    </div>
    <SearchCustomer show={showSearch} onClose={onClose}></SearchCustomer>
    </>)
}

Customer.propTypes = {
    items: PropTypes.array,
    disabled: PropTypes.bool
}

Customer.defaultProps = {
    items: [],
    disabled: false,
    title: __('customer.title'),
    limit: false
}

export default Customer;

document.querySelectorAll('customer').forEach(dom => {
    let props = Object.assign({}, dom.dataset);
    if(!!props.items) props.items = JSON.parse(props.items);
    
    ReactDOM.render(<Customer {...props} />, dom);
});