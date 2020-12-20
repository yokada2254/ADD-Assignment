import React, { useReducer, useMemo } from 'react';
import PropTypes from 'prop-types';

import { Button, OverlayTrigger, Tooltip } from 'react-bootstrap'; 

import { SelectedTypes, selectedReducer } from '../search/selected';

function Offers({status, disabled, items, transactionTypes}){
    const [offers, dispatchOffers] = useReducer(selectedReducer, items);
    const OfferIds = useMemo(() => offers.map(item => item.id), [offers]);

    console.log("offers", offers);

    const add = () => {
        dispatchOffers({
            type: SelectedTypes.ADD,
            item: {
                id: `temp_${Date.now()}`,
                transaction_type_id: 0,
                price: 0,
            }
        });
    }

    const update = (item, change) => {
        dispatchOffers({
            type: SelectedTypes.UPDATE,
            item: {...item, ...change}
        })
    }

    const makeDeal = offer_id => {
        location.href = `/transaction/create?offer_id=${offer_id}`;
    }

    return (
    <div className="card">
        <div className="card-header d-flex justify-content-between align-items-center">
            <h5 className="font-weight-bold">{ __('prefer_offer.title') }</h5>
        {
            disabled?
            <div></div>:
            <button type="button" className="btn btn-sm btn-dark" onClick={add} disabled={disabled}>
                <i className="fas fa-plus mr-2"></i>
                {__('form.add')}
            </button>
        }
        </div>
        <div className="card-body p-0">
        {
            offers.length > 0 &&
            <table className="table table-dark table-stripe m-0">
                <thead>
                <tr>
                    <td>{__('prefer_offer.transaction_type')}</td>
                    <td>{__('prefer_offer.price')}</td>
                    <td>&nbsp;</td>
                </tr>
                </thead>
                <tbody>
            {
                offers.map((item, i) => (
                <tr key={`item_${item.id}`}>
                    <td>
                        <input type="hidden" name={`offers[${i}][id]`} value={item.id} />
                        <select 
                            name={`offers[${i}][transaction_type_id]`} 
                            value={item.transaction_type_id}
                            onChange={({target}) => update(item, {transaction_type_id: target.value})}
                            className="form-control" disabled={disabled}
                        >
                        {
                            transactionTypes.map(type => (
                            <option value={type.id} key={`type_${type.id}`}>{type.name}</option>))
                        }
                        </select>
                    </td>
                    <td>
                        <div className="input-group">
                        {
                            item.transaction_type_id == 3 &&
                            <div className="input-group-prepend">
                                <span className="input-group-text">$</span>
                            </div>
                        }
                            <input 
                                type="text" name={`offers[${i}][price]`} 
                                value={item.price} 
                                onChange={({target}) => update(item, {price: target.value})}
                                className="form-control text-right" disabled={disabled}
                            />
                            
                        {
                            item.transaction_type_id != 3 &&
                            <div className="input-group-append">
                                <span className="input-group-text">10K</span>
                            </div>
                        }
                        </div>
                    </td>
                    <td>
                        <div className="btn-group">
                            <OverlayTrigger
                                placement="top"
                                overlay={props => <Tooltip {...props}>{__('package.deal')}</Tooltip>}
                            >
                                <Button className="w-50 text-white" type="button" size="sm" variant="warning" onClick={() => makeDeal(item.id)} disabled={!disabled || status != 1}>
                                    <i className="fas fa-handshake"></i>
                                </Button>
                            </OverlayTrigger>
                            <Button className="w-50"type="button" size="sm" variant="danger" onClick={() => dispatchOffers({type: SelectedTypes.DEL, item})} disabled={disabled}>
                                <i className="fas fa-trash"></i>
                            </Button>
                        </div>
                    </td>
                </tr>))
            }
                </tbody>
            </table>
        }
        </div>
    </div>)
}

Offers.propTypes = {
    items: PropTypes.array,
    disabled: PropTypes.bool,
    transactionTypes: PropTypes.array
}

Offers.defaultProps = {
    items: [],
    disabled: false,
    transactionTypes: []
}

export default Offers;