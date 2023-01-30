import React, { useState, useEffect } from 'react'
import Loader from "react-js-loader";
import { useTable, usePagination } from "react-table";
// import Header from './Header'
import CircularProgress from '@mui/material/CircularProgress';
import Papa from "papaparse";
import { Url, PubliUrl } from "../../Config"
import RefreshIcon from '@mui/icons-material/Refresh';

const TableFilter = ({ props }) => {
    const [dataLoading, setDataLoading] = useState(false);

    dataLoading && setTimeout(() => {
        setDataLoading(false);
    }, 1000);
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
                                <span>
                                    {!dataLoading ?
                                        <RefreshIcon sx={{ height: '70%' }} onClick={() => {
                                            props.refreshData ? props.setRefreshData(false) : props.setRefreshData(true)
                                            setDataLoading(true);
                                            //clearFilter();
                                        }} /> :
                                        <CircularProgress sx={{ height: '30%' }} />
                                    }
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

const UserTable = ({ props }) => {
    const {
        getTableProps,
        getTableBodyProps,
        headerGroups,
        prepareRow,
        page, // Instead of using 'rows', we'll use page,
        // which has only the rows for the active page

        // The rest of these things are super handy, too ;)
        canPreviousPage,
        canNextPage,
        pageOptions,
        pageCount,
        gotoPage,
        nextPage,
        previousPage,
        setPageSize,
        // state: { pageIndex, pageSize },
    } = useTable(
        {
            columns: props.columns,
            data: props.allUsers,
            initialState: {
                pageIndex: 0,
                pageSize: 500,
            },
        },
        usePagination
    );
    // props = {
    // ...props,
    // setPageSize: setPageSize
    //   }
    return (
        <>
            <div className='data_table-section'>
                <div className='responsive_table'>
                    <table {...getTableProps()} id="dataTable">
                        <thead>
                            {headerGroups.map(headerGroup => (
                                <tr {...headerGroup.getHeaderGroupProps()}>
                                    {headerGroup.headers.map(column => (
                                        <th {...column.getHeaderProps()}>{column.render('Header')}</th>
                                    ))}
                                </tr>
                            ))}
                        </thead>
                        <tbody {...getTableBodyProps()}>
                            {page.map((row, i) => {
                                prepareRow(row)
                                return (
                                    <tr {...row.getRowProps()}>
                                        {row.cells.map(cell => {
                                            return <td {...cell.getCellProps()}>{cell.render('Cell')}</td>
                                        })}
                                    </tr>
                                )
                            })}
                        </tbody>
                    </table>
                </div>
                <div className="pagination-section">
                    <button onClick={() => {
                        props.setPageChange(1);
                    }} disabled={props.enPreviousPage}>
                        {"<<"}
                    </button>{" "}
                    <button onClick={() => {
                        props.setPageChange(props.currentPage - 1);
                    }} disabled={props.enPreviousPage}>
                        Previous
                    </button>{" "}
                    <button onClick={() => {
                        props.setPageChange(props.currentPage + 1);
                    }} disabled={props.enNextPage}>
                        Next
                    </button>{" "}
                    <button onClick={() => {
                        props.setPageChange(props.totalPages);
                    }} disabled={props.enNextPage}>
                        {">>"}
                    </button>{" "}
                </div>
            </div>
        </>
    )
}
const Tracking = () => {

    const [isAdmin, is_admin] = useState(false);
    const [allUsers, setAllUsers] = useState(null)
    const [perPage, setPerPage] = useState(10);
    const [currentPage, setCurrentPage] = useState(null);
    const [pageChange, setPageChange] = useState(null);
    const [refreshData, setRefreshData] = useState(false);
    const [totalPages, setTotalPages] = useState(null);
    const [enPreviousPage, setEnPreviousPage] = useState(null);
    const [enNextPage, setEnNext] = useState(null);
    const [dataLoading, setDataLetloading] = useState(true);

    const columns = [
        {
            Header: 'ID',
            accessor: 'id', // accessor is the "key" in the data
        },
        {
            Header: 'Email',
            accessor: 'email',
        },
        {
            Header: 'Record',
            accessor: 'record',
        },
        {
            Header: 'Query',
            accessor: 'query',
        },
        // {
        //     Header: 'IP',
        //     accessor: 'ip',
        // },
        {
            Header: 'created_at',
            accessor: 'created_at',
            Cell: ({ value }) => {
                let today = new Date(value);
                let year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();
                let fecha = day + "-" + month + "-" + year;
                return (
                    fecha
                );
            }
        },
        
    ];

    const params = {
        perPage: perPage,
    };

    useEffect(() => {
        setDataLetloading(true);
        setEnPreviousPage(true);
        setEnNext(true);
        perPage && axios.post(`${PubliUrl}/api/gettracking?page=1`, params)
            .then(res => {
                setDataLetloading(false);
                setCurrentPage(res.data.current_page);
                setTotalPages(res.data.last_page);
                res.data.current_page == 1 ? setEnPreviousPage(true) : setEnPreviousPage(false);
                res.data.current_page == res.data.last_page ? setEnNext(true) : setEnNext(false);
                setAllUsers(res.data.data);
            })
    }, [perPage, refreshData]);

    // Next/Pre Pagi
    useEffect(() => {
        setDataLetloading(true);
        setEnPreviousPage(true);
        setEnNext(true);
        pageChange && axios.post(`${PubliUrl}/api/gettracking?page=${pageChange}`, params)
            .then(res => {
                setDataLetloading(false);
                setCurrentPage(res.data.current_page);
                setTotalPages(res.data.last_page);
                res.data.current_page == 1 ? setEnPreviousPage(true) : setEnPreviousPage(false);
                res.data.current_page == res.data.last_page ? setEnNext(true) : setEnNext(false);
                setAllUsers(res.data.data);
            })
    }, [pageChange])

    useEffect(() => {
        axios.get(`${PubliUrl}/api/isAdmin`).then(res => {
            is_admin(res.data.isAdmin);
        });
    }, []);
  
    const props = { allUsers, columns, setRefreshData, setPageChange, setAllUsers, refreshData, currentPage, dataLoading, setPerPage, enNextPage, enPreviousPage, perPage, totalPages }

    if (isAdmin) {
        return (
            <>
               
                <div id="main-content">
                <div className="main-top_bar">
                        <div className="data_entries-result">
                            <TableFilter props={props} />
                        </div>
                    </div>
                    <div className="main_body-part">

                            <UserTable props={props} />
                    </div>
                </div>
            </>
        )
    } else {
        return (
            <Loader
                type="spinner-circle"
                bgColor={"#111"}
                title={"box-rotate-x"}
                color={'#FFFFFF'}
                size={100}
            />)
    }
}

export default Tracking