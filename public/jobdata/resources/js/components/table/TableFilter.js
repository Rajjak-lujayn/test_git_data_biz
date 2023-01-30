import React from 'react'
import CsvDownload from 'react-json-to-csv'

const TableFilter = ({ props }) => {
  const TimeoutMsg = (msg) => {

    return (
      <div className="registrationMsg" style={{ padding: "0.5rem" }}>
        {msg}
      </div>)
      ;
  }

  return (
    <>
      <div className="main-top_bar">
        <div className="data_entries-result">
          <div className="header_pagination">
            <div className="container-fluid">
              <div className='left_content'>
                <span>
                  Showing{" "}
                  <strong>
                    {props.currentPage} To {props.totalPages} Entries
                  </strong>{" "}
                  {/* | Go to page:{" "} <input type="number"defaultValue={props.pageIndex + 1} onChange={(e) => {const pageNumber = e.target.value ? Number(e.target.value) - 1 : 0; props.gotoPage(pageNumber); }}/>  */}
                </span>{" "}
                <span>
                  Show
                  <select
                    value={props.perPage}
                    onChange={(e) => {
                      props.setPerPage(Number(e.target.value));
                      // props.setPageSize(Number(e.target.value));
                    }}
                  >
                    {[10, 25, 50, 100, 250, 500].map((perPage) => (
                      <option key={perPage} value={perPage}>
                        {perPage}
                      </option>
                    ))}
                  </select>
                  Entries
                </span>
              </div>
              <div className="button_wrapper">
                {!props.showRegiserBox ?
                  <span className="btn btn-success mx-3" onClick={props.clearFilter}>Clear</span>
                  : ''
                }
                {props.dataForExport ?
                  <CsvDownload data={props.dataForExport} className="btn btn-success mx-3" /> :
                  (props.showExportButton && !props.showRegiserBox) ?
                    <span className="btn btn-success mx-3" onClick={props.getAllCheckedBoxes}>Export Selected</span>
                    : ''}

                {props.showRegiserBox ? <form onSubmit={props.regiterUserEmail} className="d-flex">
                  <input type="email" name="email" className="form-control w-auto mx-3" id="enterRegistrationEmail" placeholder="Enter business email" />
                  <button className="btn btn-secondary" type="submit">Submit</button>
                </form> : ''}
                {props.registrationMsg ?
                  TimeoutMsg(props.registrationMsg)
                  : ''}
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default TableFilter