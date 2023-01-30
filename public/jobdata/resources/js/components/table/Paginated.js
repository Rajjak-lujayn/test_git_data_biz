import React, { useState, setState, useEffect } from "react";
import { useTable, usePagination, useSortBy } from "react-table";
import FilterForm from "./Filter";
import TableFilter from "./TableFilter";
// Nitesh
import { CSVLink } from "react-csv";
import { Url, PubliUrl } from "../../Config";
import { useCookies } from 'react-cookie';
import { Modal, ModalHeader, ModalBody, ModalFooter, Button } from 'reactstrap';
import 'bootstrap/dist/css/bootstrap.css'
export const Paginated = ({ props }) => {
// Nitesh
const fileName = "users-detail";
  const [userData, setUserData] = useState([]);
  const [loading, setLoading] = useState(false);
  const [recordmessage, setrecordmessage] = useState(false);
  const [readytoexport, readyForexport] = useState(false);
  const [setRecord, setrecord] = useState(false);
  const [registrationMsg, registration_msg] = useState(false);
  const [cookies, setCookie] = useCookies(['auth']);
  const [modal, setmodal] = useState(false);

  const headers = [
    { label: "Id", key: "id" },
    { label: "Date", key: "date" },
    { label: "Job Title", key: "job_title" },
    { label: "Company", key: "company" },
    { label: "Website", key: "website" },
    { label: "Industry", key: "industry" },
    { label: "Salary", key: "salary" },
    { label: "Level", key: "level" },
    { label: "Remote", key: "remote" },
    { label: "City", key: "city" },
    { label: "State", key: "state" },
    { label: "Area", key: "area" },
    { label: "Zipcode", key: "zipcode" },
    { label: "Phone", key: "phone" }
  ];
  console.log(props);
  const formsubmitted = (e) => {
    
    e.preventDefault();
    let record = e.target.record.value;

    const params = {
      job_title: props.searchByJobTitle ? props.searchByJobTitle : '',
      company: props.searchByCompany ? props.searchByCompany : '',
      industry: props.filterByIndustry ? props.filterByIndustry : '',
      level: props.filterByLevel ? props.filterByLevel : '',
      state: props.filterByState ? props.filterByState : '',
      salary: props.filterBySalary ? props.filterBySalary : '',
      remote: props.filterByRemote ? props.filterByRemote : '',
      record: record ? record : '',
    };
    setLoading(true);
    axios.post(`${PubliUrl}/api/recordExport`, params).then(res => {
      setUserData(res.data);
      readyForexport(true);
      setLoading(false);
      return;
    }).catch(err => {

      if (err.response.data.htmlErrorMsg) {
        registration_msg(err.response.data.htmlErrorMsg);
      }
      err = err.response.data.errors;
      if (!err.email_registered) {
        show_regiser_box(true);
      }
    });


  }
  const TimeoutMsg = (msg) => {

    return (
      <div className="registrationMsg" style={{ padding: "0.5rem" }}>
        {msg}
      </div>)
      ;
  } 
  useEffect(() => {
    setTimeout(function () {
      registration_msg(false);
    }, 10000);
  }, [registrationMsg]);

// end Nitesh


  const {
    getTableProps,
    getTableBodyProps,
    headerGroups,
    page,
    nextPage,
    previousPage,
    canPreviousPage,
    canNextPage,
    pageOptions,
    state,
    gotoPage,
    pageCount,
    rows,
    setPageSize,
    prepareRow
  } = useTable(
    {
      columns: props.columns,
      data: props.data,
      initialState: {
        // pageIndex: 1,
        pageSize: 500
      }
    },
    useSortBy,
    usePagination
  );

  // props = {
  //   ...props,
  //   setPageSize: setPageSize
  // }
  // const { pageIndex, pageSize } = state;

  return (
    <>
      <div className="main_body-part">
        <div className="data_table-section">
          <div className="responsive_table">
            <table {...getTableProps()} id="dataTable">
              <thead>
                {headerGroups.map((headerGroup) => (
                  <tr {...headerGroup.getHeaderGroupProps()}>
                    {headerGroup.headers.map((column) => (
                      <>
                        {
                          column.Header == "#" ?
                            <th {...column.getHeaderProps()}>
                              <div className="form-check">
                                <input className="form-check-input" id="selectAllCheckboxes" onClick={() => props.modal} onChange={props.checkAll} type="checkbox" />
                              </div>
                            </th> :
                            // <th {...column.getHeaderProps()}>
                            <th {...column.getHeaderProps(column.getSortByToggleProps())}>
                              {column.render("Header")}
                              {/* <span>
                          {column.isSorted
                            ? column.isSortedDesc
                              ? ' 🔽'
                              : ' 🔼'
                            : ''}
                            { !column.isSorted && (
                              column.render("Header")=="Job Title" || 
                              column.render("Header") =="Company" || column.render("Header") =="City")
                              ? ' 🔽': ''}
                          </span> */}
                            </th>
                        }
                      </>
                    )
                    )}
                  </tr>
                ))}
              </thead>
              {props.dataLoading == false ?
                <tbody {...getTableBodyProps()} >
                  {page.map((row) => {
                    prepareRow(row);
                    return (
                      <tr {...row.getRowProps()}>
                        {row.cells.map((cell) => {
                          if (cell.column.id == "id") {
                            return (
                              <td {...cell.getCellProps()}>
                                <div className="form-check">
                                  <input
                                    className="form-check-input select-id"
                                    onClick={(e) => {
                                      let selectAllCheckboxes = document.getElementById("selectAllCheckboxes");
                                      selectAllCheckboxes.checked && !e.target.checked ? selectAllCheckboxes.checked = false : '';
                                    }}
                                    type="checkbox"
                                    value={cell.render("Cell").props.cell.value} />
                                </div>
                              </td>
                            );
                          }
                          return (
                            <td {...cell.getCellProps()}>{cell.render("Cell")}</td>
                          );
                        })}
                      </tr>
                    );
                  })}
                </tbody>
                :
                <tfoot>
                  <tr>
                    <td colSpan={11}>Loading...</td>
                  </tr>
                </tfoot>
              }
              {
                props.data == '' && !props.dataLoading &&
                <tfoot>
                  <tr>
                    <td colSpan={11}>No Records Found</td>
                  </tr>
                </tfoot>
              }
            </table>
          </div>
        </div>
        {/* Nitesh */}
        <div className="model-popup">
          <Modal isOpen={props.modal} modalTransition={{ timeout: 700 }} backdropTransition={{ timeout: 1300 }}
          >
            <ModalHeader toggle={() => props.setmodal(false)}>Export Data</ModalHeader>
            <ModalBody>
              {cookies.auth ?
                <form onSubmit={formsubmitted}>
                  <div className="mb-3">
                    <label className="form-label">Enter How Many record You Want to Export</label>
                    <input type="text" className="form-control" name="record" id="record" value={props.DataName} required />
                  </div>
                  <input type="submit" value="Submit" />

                  {readytoexport ?
                    <CSVLink
                      headers={headers}
                      data={userData}
                      filename={fileName}
                      target="_blank"
                    >
                      {loading && !registrationMsg ? 'Loading csv...' : 'Export Data'}
                    </CSVLink>
                    : ''}
                </form>
                : <form onSubmit={props.regiterUserEmail} className="d-flex">
                  <input type="email" name="email" className="form-control w-auto mx-3" id="enterRegistrationEmail" placeholder="Enter business email" />
                  <button className="btn btn-secondary" type="submit">Submit</button>
                </form>}
             
            </ModalBody>
            <ModalFooter>
            <div className="modal-registrationMsg">
              {props.registrationMsg ?
              
                  TimeoutMsg(props.registrationMsg)
                  : ''}
                   {registrationMsg ?
              
              TimeoutMsg(registrationMsg)
              : ''}
              </div>
            </ModalFooter>
          </Modal>
        </div>
        {/* End Nitesh */}
        <div className="pagination-section">
          <button onClick={() => {
            props.setPageChange(1);
            props.pChange ? props.setPChange(false): props.setPChange(true);
          }} disabled={props.enPreviousPage}>
            {"<<"}
          </button>{" "}
          <button onClick={() => {
            props.setPageChange(props.currentPage - 1);
            props.pChange ? props.setPChange(false): props.setPChange(true);
          }} disabled={props.enPreviousPage}>
            Previous
          </button>{" "}
          <button onClick={() => {
            props.setPageChange(props.currentPage + 1);
            props.pChange ? props.setPChange(false): props.setPChange(true);
          }} disabled={props.enNextPage}>
            Next
          </button>{" "}
          <button onClick={() => {
            props.setPageChange(props.totalPages);
            props.pChange ? props.setPChange(false): props.setPChange(true);
          }} disabled={props.enNextPage}>
            {">>"}
          </button>{" "}
        </div>
      </div>
    </>
  );
};
