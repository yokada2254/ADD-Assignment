import React, {useState} from 'react';
import ReactDOM from 'react-dom';
import propTypes from 'prop-types';

import 'bootstrap/dist/css/bootstrap.min.css';

import Offers from './offers';
import Property from '../property';
import People from '../people';

function Package(props){
    const data = !!props.package?JSON.parse(props.package):undefined;
    const transactionTypes = JSON.parse(props.transactionTypes);
    const [status, setStatus] = useState(data?.status_id??0);
    const disabled = props.state == "SHOW";
    
    console.log("data", data);

    return (
    <>
    <div className="container">
        <div className="form-row d-flex justify-content-between align-items-center">
            <div className="col-2">
                <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                        <div className="input-group-text">{__('package.status')}</div>
                    </div>
                    <select 
                        className="form-control form-control-sm" 
                        onChange={({target}) => setStatus(target.value)} 
                        value={status} name="status_id" disabled={disabled}
                    >
                    {
                        window?._package_statuses.map(status => (
                        <option value={status.id} key={`status_${status.id}`}>{status.name}</option>))
                    }
                    </select>
                </div>
            </div>

            <div className="col">
                <div className="d-flex justify-content-end">
                    <div className="btn-group" role="group">
                    {
                        disabled?
                        <a href={`/package/${data.id}/edit`} type="submit" className="btn btn-sm btn-info">
                            <i className="fas fa-edit mr-2"></i>
                            { __('form.edit') }
                        </a>:
                        <>
                        <button type="submit" className="btn btn-sm btn-primary">
                            <i className="fas fa-save mr-2"></i>
                            { __('form.save') }
                        </button>
                        <a className="btn btn-sm btn-danger" href={`/package/${data?.id??''}`}>
                            <i className="fas fa-times mr-2"></i>
                            { __('form.cancel') }
                        </a>
                        </>
                    }
                    </div>
                </div>
            </div>

        </div>

        <div className="row">
            <div className="col-12 my-1">
                <Property disabled={disabled} items={data?.properties??[]} />
            </div>
            
            <div className="col-lg-6 col-md-12 my-1">
                <Offers disabled={disabled} items={data?.offers??[]} transactionTypes={transactionTypes} status={status} />
            </div>
            
            <div className="col-lg-6 col-md-12 my-1">
                <People title={__('package.owner')} disabled={disabled} items={data?.owners??[]} />
            </div>
        </div>
    {
        data?.id && (
        <div className="alert alert-light">
            <div className="row d-flex align-items-center justify-content-between">
                <p className="mx-1 my-0">
                    <strong className="mr-1">{ __('common.created_by') }</strong>
                    { data.created_by.name }
                    <strong className="mx-1">@</strong>
                    { data.created_at }
                </p>
                <p className="mx-1 my-0">
                    <strong className="mr-1">{ __('common.updated_by') }</strong>
                    { data.updated_by.name }
                    <strong className="mx-1">@</strong>
                    { data.updated_at }
                </p>
            </div>
        </div>)
    }
    </div>
    </>);
}

Package.propTypes = {
    state: propTypes.oneOf(['SHOW', 'EDIT']),
    package: propTypes.string,
    transaction: propTypes.string
}

export default Package;

(function(){
    let dom = document.querySelector("package");
    if(dom){
        let props = Object.assign({}, dom.dataset);
        ReactDOM.render(<Package {...props} />, dom);
    }
}());