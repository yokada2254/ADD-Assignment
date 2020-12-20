import React from 'react';

import propTypes from 'prop-types';

function Pages(props){
    const {updateFunc, currentPage, lastPage} = props;

    return (
    <div className="d-flex align-items-center justify-content-center">
        <div className="btn-group btn-group-sm">

            <button 
                type="button" className="btn btn-sm btn-secondary" 
                disabled={currentPage == 1} onClick={() => updateFunc(currentPage - 1)}
            >
                <i className="fas fa-chevron-left"></i>
            </button>

            <select className="form-control form-control-sm" onChange={({target}) => updateFunc(target.value)} value={currentPage}>
            {
                Array(lastPage).fill("").map((_, i) => (
                <option value={i+1} key={`page_${i}`}>P.{i+1}</option>))
            }
            </select>
            
            <button 
                type="button" className="btn btn-sm btn-secondary" 
                disabled={currentPage == lastPage} onClick={() => updateFunc(currentPage + 1)}
            >
                <i className="fas fa-chevron-right"></i>
            </button>

        </div>
    </div>)
}

Pages.propTypes = {
    currentPage: propTypes.number,
    lastPage: propTypes.number,
    updateFunc: propTypes.func
}

export default Pages;