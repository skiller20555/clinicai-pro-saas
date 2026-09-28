import React from 'react';

export default function Sidebar() {
  return (
    <aside className="fixed inset-y-0 left-0 w-72 bg-slate-900 text-slate-100 p-6">
      <div className="mb-10 text-2xl font-bold">ClinicAI Pro</div>
      <nav className="space-y-2">
        <div className="rounded-lg bg-slate-800 px-3 py-2">Dashboard</div>
        <div className="rounded-lg px-3 py-2 text-slate-300">Patients</div>
        <div className="rounded-lg px-3 py-2 text-slate-300">Appointments</div>
        <div className="rounded-lg px-3 py-2 text-slate-300">Medical Records</div>
        <div className="rounded-lg px-3 py-2 text-slate-300">Billing</div>
        <div className="rounded-lg px-3 py-2 text-slate-300">Dental</div>
        <div className="rounded-lg px-3 py-2 text-slate-300">AI Assistant</div>
      </nav>
    </aside>
  );
}
